<?php

use RaihanNih\Factory\SessionFactory;

SessionFactory::init();

if (SessionFactory::destroyAll()) {
    echo "<script>alert('Berhasil Logout');</script>";
    echo "<script>window.location = '/login';</script>";
}
