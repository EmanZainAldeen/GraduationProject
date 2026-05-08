<?php

declare(strict_types=1);

namespace App\Support;

final class Env
{
    private static bool $loaded = false;

    public static function get(string $key, ?string $default = null): ?string
    {
        self::load();

        $value = getenv($key);
        if ($value === false) {
            return $default;
        }

        return $value;
    }

    private static function load(): void
    {
        if (self::$loaded) {
            return;
        }

        $envPath = dirname(__DIR__, 2) . '/.env';
        if (is_readable($envPath)) {
            $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                    continue;
                }

                [$name, $value] = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);

                if (
                    (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
                    (str_starts_with($value, "'") && str_ends_with($value, "'"))
                ) {
                    $value = substr($value, 1, -1);
                }

                if (getenv($name) === false) {
                    putenv($name . '=' . $value);
                    $_ENV[$name] = $value;
                }
            }
        }

        self::$loaded = true;
    }
}
