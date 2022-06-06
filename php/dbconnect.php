<?php
//error_reporting(0);
ob_start();
session_start();
$siteName = "Registro de Pagos";


DEFINE("BASE_URL", "http://localhost/pagos/");

DEFINE('DB_USER', 'root');
DEFINE('DB_PSWD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'pagos');

date_default_timezone_set('America/Bogota');
$conn =  new mysqli(DB_HOST, DB_USER, DB_PSWD, DB_NAME);
if ($conn->connect_error)
    die("Failed to connect database " . $conn->connect_error);
