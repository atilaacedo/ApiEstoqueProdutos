<?php

use App\Core\EnvLoader;

session_start();

require "../vendor/autoload.php";

require_once '../app/core/EnvLoader.php';
EnvLoader::load();