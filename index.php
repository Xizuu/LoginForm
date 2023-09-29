<?php

require_once "vendor/autoload.php";

use Steampixel\Route;

const BASEPATH = '/';
const ROOT = "src/";
const RESOURCES = "resources/";

Route::add("/", fn () => include_once ROOT . "Views/Index.views.php");
Route::add("/login", fn () => include_once ROOT . "Views/Login.views.php", ["post", "get"]);
Route::add("/register", fn () => include_once ROOT . "Views/Register.views.php", ["post", "get"]);
Route::add("/logout", fn () => include_once ROOT . "Logout.php");

Route::run(BASEPATH);
