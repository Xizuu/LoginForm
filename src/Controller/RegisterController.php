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
<!doctype html>
<html>
<title>Register - Your Website</title>

</html>

<body style="text-align: center;">
    <hr>
    <h1>Not Allowed</h1>
    <hr>
</body>