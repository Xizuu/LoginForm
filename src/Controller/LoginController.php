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
<!doctype html>
<html>
<title>Login - Your Website</title>

</html>

<body style="text-align: center;">
    <hr>
    <h1>Not Allowed</h1>
    <hr>
</body>