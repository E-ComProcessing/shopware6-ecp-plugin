<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitce11030aad0290913fd2eb0f72cc81cf
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'Ecomprocessing\\Genesis\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Ecomprocessing\\Genesis\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'G' => 
        array (
            'Genesis' => 
            array (
                0 => __DIR__ . '/..' . '/genesisgateway/genesis_php/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitce11030aad0290913fd2eb0f72cc81cf::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitce11030aad0290913fd2eb0f72cc81cf::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitce11030aad0290913fd2eb0f72cc81cf::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}