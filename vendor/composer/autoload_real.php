<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitd2cd57d8d6f7a1ba5bbc436e98fc7382
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

        spl_autoload_register(array('ComposerAutoloaderInitd2cd57d8d6f7a1ba5bbc436e98fc7382', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitd2cd57d8d6f7a1ba5bbc436e98fc7382', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitd2cd57d8d6f7a1ba5bbc436e98fc7382::getInitializer($loader));

        $loader->setClassMapAuthoritative(true);
        $loader->register(true);

        $includeFiles = \Composer\Autoload\ComposerStaticInitd2cd57d8d6f7a1ba5bbc436e98fc7382::$files;
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequired2cd57d8d6f7a1ba5bbc436e98fc7382($fileIdentifier, $file);
        }

        return $loader;
    }
}

/**
 * @param string $fileIdentifier
 * @param string $file
 * @return void
 */
function composerRequired2cd57d8d6f7a1ba5bbc436e98fc7382($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

        require $file;
    }
}
