<?php

use RaihanNih\Factory\SessionFactory;
use RaihanNih\Utils\Config;
use RaihanNih\Utils\Mysql;

SessionFactory::init();

$config = new Config(RESOURCES . "config.yml");
if (!SessionFactory::hasStarted("username")) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["login"])) {
            $username = $_POST["username"];
            $password = sha1($_POST["password"]);

            $mysql = new Mysql($config->get("MYSQL_HOST") ?? "localhost", $config->get("MYSQL_USER") ?? "root", $config->get("MYSQL_PASSWORD") ?? "", $config->get("MYSQL_DATABASE"));
            $rowAll = $mysql->executeQuery("SELECT * FROM users WHERE username = :username AND password = :password", [
                ":username" => $username,
                ":password" => $password
            ]);
            $rowCount = $rowAll->rowCount();
            if ($rowCount !== 0) {
                SessionFactory::set("username", $username);
                echo "<script>alert('Berhasil login');</script>";
                echo "<script>window.location = '/';</script>";
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
    <style>
        body {
            background-color: #080825;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'Open Sans', sans-serif;
        }

        .login-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 1px 5px 20px rgba(255, 255, 255, 0.2);
            padding: 40px;
            max-width: 400px;
            margin: 0 auto;
        }

        .login-container h5 {
            text-align: center;
            color: #000;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            border: 2px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            outline: none;
            transition: border-color 0.3s ease;
            width: 100%;
        }

        .login-form input[type="text"]:focus,
        .login-form input[type="password"]:focus {
            border-color: #000;
        }

        .login-form input[type="text"]:hover,
        .login-form input[type="password"]:hover {
            border-color: #000;
        }

        .login-form .form-group {
            margin-bottom: 20px;
        }

        .login-form label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .login-form button {
            background-color: #000;
            color: #fff;
            border: 2px solid #ccc;
            border-radius: 5px;
            padding: 15px 30px;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
            width: 100%;
        }

        .login-form button:hover {
            background-color: #222;
            border-color: #333;
            color: #fff;
        }

        .register-divider {
            text-align: center;
            margin-top: 15px;
        }

        .register-divider hr {
            border: none;
            height: 2px;
            background: #ddd;
            margin: 10px 0;
        }

        .register-link {
            text-align: center;
            margin-top: 10px;
        }

        .register-link a {
            text-decoration: none;
            color: #000;
            transition: border-bottom 0.3s ease;
            margin-bottom: -2px;
        }

        .register-link a:hover,
        .register-link a:focus {
            border-bottom: 1px solid #000;
        }
    </style>
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