<?php

declare(strict_types=1);

use App\Database\DatabaseConnection;

require_once __DIR__ . '/../bootstrap/app.php';

try {
    $conn = DatabaseConnection::connect();
} catch (RuntimeException $exception) {
    die($exception->getMessage());
}
