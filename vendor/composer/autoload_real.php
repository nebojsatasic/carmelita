<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitb65009e2ebd28de09a807ecf4b68b1ab
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitb65009e2ebd28de09a807ecf4b68b1ab', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitb65009e2ebd28de09a807ecf4b68b1ab', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitb65009e2ebd28de09a807ecf4b68b1ab::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
