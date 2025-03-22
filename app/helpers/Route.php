<?php

class Route
{
    /**
     * Compose URL using given controller name, method name and GET parameters
     *
     * @param string $path
     * @param array $params
     * @return string
     */
    public static function get(string $path, array $params = []): string
    {
        $url = Config::get('domain') . $path . '/';

    foreach ($params as $key => $value) {
        $url .= $key . '/' . $value . '/';
    }

    return $url;
    }
}
