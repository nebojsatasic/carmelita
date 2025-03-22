<?php

abstract class Controller
{
    /**
     * Loading views
     */
    public static function view(string $view, $data = null, $message = null): void
    {
        require_once 'app/views/' . $view . '.php';
    }

    /**
     * Loading admin views
     */
    public static function adminView(string $view, $data = null, $message = null): void
    {
        require_once 'app/views/admin/' . $view . '.php';
    }
}
