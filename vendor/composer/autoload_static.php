<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitabd098cf55efb69a617c147536d50f1b
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Castlegate\\ExternalLinkChecker\\' => 31,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Castlegate\\ExternalLinkChecker\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitabd098cf55efb69a617c147536d50f1b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitabd098cf55efb69a617c147536d50f1b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitabd098cf55efb69a617c147536d50f1b::$classMap;

        }, null, ClassLoader::class);
    }
}
