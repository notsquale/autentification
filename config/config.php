<?php

//url du site
session_start();
$baseUrl = 'http://localhost/POO/autentification/v1';



//fonction sanitise
function sanitize($value) 
{
    return trim(htmlspecialchars($value));
}

function redirect($url = '/') {
    global $baseUrl;

    header ('Location:'.$baseUrl.$url);

}

function isLogged() {
    // return isset[$_SESSION['user]] ? $_SESSION['user] : false;
    return $_SESSION['user'] ?? false;
}



//connection BDD
define('DB_HOST', 'localhost');
define('DB_NAME', 'autentification');
define('DB_USER', 'root');
define('DB_PASSWORD', '');


$db = new PDO(
    'mysql:host='.DB_HOST.';dbname='.DB_NAME,
DB_USER,
DB_PASSWORD,
[PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING]
);