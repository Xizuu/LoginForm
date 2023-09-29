<?php

use RaihanNih\Factory\SessionFactory;
use RaihanNih\Utils\Config;
use RaihanNih\Utils\Mysql;

SessionFactory::init();

$config = new Config(RESOURCES . "/config.yml");
if (!SessionFactory::hasStarted("username")) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["login"])) {
            $username = $_POST["username"];
            $password = md5($_POST["password"]);

            $mysql = new Mysql($config->get("MYSQL_HOST") ?? "localhost", $config->get("MYSQL_USER") ?? "root", $config->get("MYSQL_PASSWORD") ?? "", $config->get("MYSQL_DATABASE"));
            $rowAll = $mysql->executeQuery("SELECT * FROM users WHERE username = :username", [
                ":username" => $username
            ]);
            $rowCount = $rowAll->rowCount();
            if ($rowCount > 0) {
                $row = $rowAll->fetch(\PDO::FETCH_ASSOC);
                if ($password == $row["password"]) {
                    SessionFactory::set("username", $username);
                    echo "<script>alert('Berhasil login');</script>";
                    echo "<script>window.location = '/';</script>";
                } else {
                    echo "<script>alert('Password salah');</script>";
                    echo "<script>window.location = '/login';</script>";
                }
            } else {
                echo "<script>alert('Username atau password salah');</script>";
                echo "<script>window.location = '/login';</script>";
            }
        }
    }
} else {
    echo "<script>window.location = '/';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Your Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600|Raleway:400,700|Karla:400,700|Poppins:400,500,600,700|Montserrat:400|Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="<?= RESOURCES ?>/css/Login.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="login-container">
                    <h5 class="mb-4">Secure User Login</h5>
                    <form class="login-form" method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" placeholder="Enter Username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" placeholder="Enter Password" name="password" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="login" class="btn">Login</button>
                        </div>
                    </form>
                    <div class="register-divider">
                        <hr>
                        <div class="register-link">
                            <a href="/register">Create a New Account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>