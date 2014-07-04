<?php
namespace Jlapp\Swaggervel;
use Composer\Script\CommandEvent;
use Symfony\Component\Security\Core\Exception\RuntimeException;

class Updater {
    public static function postUpdate(CommandEvent $event)
    {
        $appdir     = $event->getComposer()->getConfig()->get("app-dir");
        $docdir     = $event->getComposer()->getConfig()->get("doc-dir");

        $io = $event->getIO();
        $io->write("Swaggervel: building docs.");
        if (!file_exists($appdir)) {
            $io->write("Swaggervel: app-dir not found: ".$appdir);
        }
        if (!file_exists($docdir)) {
            $io->write("Swaggervel: doc-dir not found: ".$docdir);
        }

        exec("php ./vendor/zircote/swagger-php/swagger.phar ".$appdir." -o ".$docdir);
    }
} 