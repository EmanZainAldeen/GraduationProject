<?php

$dbConfig = require __DIR__ . '/../config/database.php';

$host = $dbConfig['host'];
$user = $dbConfig['user'];
$passward = $dbConfig['password'];
$database = $dbConfig['name'];
$port = (int) $dbConfig['port'];

$conn = mysqli_connect($host, $user, $passward, $database, $port);

if (!$conn) {
    die('connection failed: ' . mysqli_connect_error());
}

if (!empty($dbConfig['charset'])) {
    mysqli_set_charset($conn, $dbConfig['charset']);
}
