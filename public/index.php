<?php
require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../routes/api.php';

error_reporting(E_ALL);
use App\Lib\Routes;

Routes::dispatch();