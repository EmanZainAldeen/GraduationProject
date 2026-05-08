<?php

declare(strict_types=1);

namespace App\Database;

use App\Support\Env;
use mysqli;
use RuntimeException;

final class DatabaseConnection
{
    public static function connect(): mysqli
    {
        $host = Env::get('DB_HOST', 'localhost');
        $port = (int) Env::get('DB_PORT', '3306');
        $name = Env::get('DB_DATABASE', 'Basma');
        $user = Env::get('DB_USERNAME', 'root');
        $password = Env::get('DB_PASSWORD', '12345');
        $charset = Env::get('DB_CHARSET', 'utf8mb4');

        $connection = mysqli_connect($host, $user, $password, $name, $port);

        if (!$connection) {
            throw new RuntimeException('Database connection failed: ' . mysqli_connect_error());
        }

        if (!empty($charset)) {
            mysqli_set_charset($connection, $charset);
        }

        return $connection;
    }
}
