<?php

use RaihanNih\Factory\SessionFactory;
use RaihanNih\Utils\Config;
use RaihanNih\Utils\Mysql;

$config = new Config(RESOURCES . "/config.yml");
if (!SessionFactory::hasStarted("username")) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["register"])) {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $password = $_POST["password"];
            $rpassword = $_POST["rpassword"];

            if ($password == $rpassword) {
                if (strlen($password) < 6) {
                    echo "<script>alert('Password harus berisikan minimal 6 karakter!');</script>";
                    echo "<script>window.location = '/register';</script>";
                    exit;
                }
                if (!is_numeric($phone)) {
                    echo "<script>alert('Phone harus berisikan angka!');</script>";
                    echo "<script>window.location = '/register';</script>";
                    exit;
                }
                $mysql = new Mysql($config->get("MYSQL_HOST") ?? "localhost", $config->get("MYSQL_USER") ?? "root", $config->get("MYSQL_PASSWORD") ?? "", $config->get("MYSQL_DATABASE"));
                $rowAll = $mysql->executeQuery("SELECT * FROM users WHERE username = :username OR email = :email", [
                    ":username" => $username,
                    ":email" => $email
                ]);

                if ($rowAll->rowCount() == 0) {
                    $mysql->executeQuery("INSERT INTO users (username, email, phone, password) VALUES (:username, :email, :phone, :password)", [
                        ":username" => $username,
                        ":email" => $email,
                        ":phone" => $phone,
                        ":password" => md5($password)
                    ]);
                    echo "<script>alert('Berhasil mendaftar!');</script>";
                    echo "<script>window.location = '/login';</script>";
                } else {
                    echo "<script>alert('Username atau email telah digunakan!');</script>";
                    echo "<script>window.location = '/register';</script>";
                }
            } else {
                echo "<script>alert('Password tidak sesuai!');</script>";
                echo "<script>window.location = '/register';</script>";
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
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600|Raleway:400,700|Karla:400,700|Poppins:400,500,600,700|Montserrat:400|Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="<?= RESOURCES ?>/css/Register.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h5 class="mb-4">Register</h5>
                    <form class="login-form" method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" placeholder="Enter Username" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" placeholder="Enter Email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" placeholder="Enter Phone Number" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" placeholder="Enter Password" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="rpassword">Repeat Password</label>
                            <input type="password" class="form-control" placeholder="Repeat Password" id="rpassword" name="rpassword" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="register" name="register" class="btn">Register</button>
                        </div>
                    </form>
                    <div class="register-divider">
                        <hr>
                        <div class="register-link">
                            <p>Already Registered? <a href="/login">Login Here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>