<?php

$loader = @include __DIR__ . '/../vendor/autoload.php';
if(!$loader)
    $loader = @include __DIR__ . '/../../../../../../vendor/autoload.php';

if (!$loader) {
    echo <<<EOT
You need to install the project dependencies using Composer:
$ wget http://getcomposer.org/composer.phar
OR
$ curl -s https://getcomposer.org/installer | php
$ php composer.phar install --dev
$ phpunit
EOT;

    exit(1);
}



$greenMail = sys_get_temp_dir().'/greenmail-standalone-1.5.7.jar';
if(!file_exists($greenMail)) {
    echo "\nDownloading GreenMail...";
    file_put_contents($greenMail, file_get_contents("http://central.maven.org/maven2/com/icegreen/greenmail-standalone/1.5.7/greenmail-standalone-1.5.7.jar"));
    echo "OK\n";
}
if(sha1_file($greenMail) == '777f6773fa7aa13c4abecbb6fad856df57ca29ed') {

    exec("java -Dgreenmail.setup.test.smtp -Dgreenmail.setup.test.imap -Dgreenmail.users=user:pass -jar \"{$greenMail}\" > /dev/null 2>/dev/null &");

    register_shutdown_function(function() {
        exec("pkill -f greenmail");
    });

} else throw new \Exception("Bad checksum for file $greenMail\n");




//$loader->add('Bazinga\Bundle\JsTranslationBundle\Tests', __DIR__);
