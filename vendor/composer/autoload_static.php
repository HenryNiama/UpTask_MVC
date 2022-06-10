<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0e37d2bace4f6072ea91199e8f97ff03
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Model\\' => 6,
            'MVC\\' => 4,
        ),
        'C' => 
        array (
            'Controllers\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Model\\' => 
        array (
            0 => __DIR__ . '/../..' . '/models',
        ),
        'MVC\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
        'Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/controllers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0e37d2bace4f6072ea91199e8f97ff03::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0e37d2bace4f6072ea91199e8f97ff03::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0e37d2bace4f6072ea91199e8f97ff03::$classMap;

        }, null, ClassLoader::class);
    }
}
