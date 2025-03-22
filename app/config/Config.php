<?php

class Config
{
    /**
     * Getting configuration values.
     *
     * @param string $path
     * @return mixed
     */
    public static function get($path)
    {
        $result = $GLOBALS['config'];
        $path = explode('/', $path);

        foreach ($path as $part) {
            if (isset($result[$part])) {
                $result = $result[$part];
            }
        }

        return $result;
    }    
}
