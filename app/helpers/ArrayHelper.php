<?php

class ArrayHelper
{
    /**
     * Remove tags and white spaces from  elements of an array
     *
     * @param array $array
     * @return array
     */
    public static function clean(array $array): array
    {
        $newArray = [];

        foreach ($array as $key => $value) {
            $key = trim(strip_tags($key));
            $value = trim(strip_tags($value));
            $newArray[$key] = $value;
        }

        return $newArray;
    }
}
