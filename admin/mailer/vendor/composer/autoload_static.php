<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9972332bf92e1e520b2007085f35e116
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9972332bf92e1e520b2007085f35e116::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9972332bf92e1e520b2007085f35e116::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
