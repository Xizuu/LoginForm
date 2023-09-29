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

    public static function set(string $sessionName, string $sessionValue): void
    {
        $_SESSION[$sessionName] = $sessionValue;
    }

    public static function get(string $sessionName): string
    {
        return $_SESSION[$sessionName];
    }

    public static function destroy(string $sessionName): void
    {
        unset($_SESSION[$sessionName]);
    }

    public static function destroyAll(): bool
    {
        return session_destroy();
    }

    public static function hasStarted(string $sessionName): bool
    {
        return isset($_SESSION[$sessionName]);
    }
}
