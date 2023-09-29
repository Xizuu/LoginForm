<?php

use RaihanNih\Factory\SessionFactory;

SessionFactory::init();

if (!SessionFactory::hasStarted("username")) {
    echo "<script>window.location = '/login';</script>";
}
?>
<h1>Selamat datang, <?= SessionFactory::get("username") ?></h1>
<a href="/logout">Logout</a>