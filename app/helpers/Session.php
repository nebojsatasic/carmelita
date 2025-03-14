<?php

class Session
{
    /**
     * Check whether there is a session variable with the specified key
     *
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
    if (isset($_SESSION[$key])) {
        return true;
    } else {
        return false;
    }
    }

    /**
     * Set a session variable with the given key and value
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get the value of a session variable associated with the specified key
     *
     * @param $key
     * @return mixed
     */
    public static function get(string $key): mixed
    {
        if (isset($_SESSION[$key])) {
            $value = $_SESSION[$key];
            return $value;
        }

        return false;
    }

    /**
     * Unset a session variable associated with the given key
     *
     * @param string $key
     * @return void
     */
    public static function unset(string $key): void
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
}
