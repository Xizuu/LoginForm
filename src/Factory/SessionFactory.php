<?php

namespace RaihanNih\Factory;

class SessionFactory
{

    public static function init(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set(string $k, string $v): void
    {
        $_SESSION[$k] = $v;
    }

    public static function get(string $k): ?string
    {
        return $_SESSION[$k] ?? null;
    }

    public static function destroy(string $k): void
    {
        unset($_SESSION[$k]);
    }

    public static function destroyAll(): bool
    {
        return session_destroy();
    }

    public static function hasStarted(string $k): bool
    {
        return isset($_SESSION[$k]);
    }
}
