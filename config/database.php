<?php

require_once __DIR__ . '/../bootstrap/env.php';

return [
    'host' => env('DB_HOST', 'localhost'),
    'port' => env('DB_PORT', '3306'),
    'name' => env('DB_DATABASE', 'Basma'),
    'user' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', '12345'),
    'charset' => env('DB_CHARSET', 'utf8mb4'),
];
