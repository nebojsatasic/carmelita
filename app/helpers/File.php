<?php

class File
{
    /**
     * Upload a file
     *
     * @param object $file
     * @param string $newName
     * @param string $path
     * @param int Size
     * @param array $allowedTypes
     * @return string|bool
     */
    public static function upload(
        $file,
        $newName,
        $path = '',
        $maxSize = 2 * 1024 * 1024,
        $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png']
    ) {
        $originalName = $file['name'];
        $originalNameArr = explode('.', $originalName);
        $originalNameText = $originalNameArr[0];
        $originalExt = $originalNameArr[1];
        $originalType = strtolower($file['type']);
        $size = $file['size'];
        $tmpName = $file['tmp_name'];
        $newName = str_replace(' ', '_', $newName);
        $destName = $path . '/' . $newName . '_' . time() . '.' . $originalExt;

        if ($size < $maxSize && in_array($originalType, $allowedTypes)) {
            if (move_uploaded_file($tmpName, $destName)) {
                return $destName;
            } else {
                return false;
            }
        }
    }
}
