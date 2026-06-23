<?php
$host = 'localhost';
$user = 'root';
$pass = 'root';
$db   = 'farmaceuticadb';

$obcon = new mysqli($host, $user, $pass, $db);

if ($obcon->connect_error)
    die('Conexión fallida: ' . $obcon->connect_error);
?>