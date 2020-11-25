<?php
declare(strict_types=1);

namespace SlackUnfurl\Composer;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use RuntimeException;

final class RegisterPlugin implements PluginInterface, EventSubscriberInterface
{
    public function activate(Composer $composer, IOInterface $io): void
    {
        // Nothing to do here, as all features are provided through event listeners
    }

    public function deactivate(Composer $composer, IOInterface $io): void
    {
        // Nothing to do here, as all features are provided through event listeners
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
        // Nothing to do here, as all features are provided through event listeners
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ScriptEvents::POST_AUTOLOAD_DUMP => 'registerPlugins',
            ScriptEvents::POST_INSTALL_CMD => 'registerPlugins',
            ScriptEvents::POST_ROOT_PACKAGE_INSTALL => 'registerPlugins',
        ];
    }

    /**
     * @throws RuntimeException
     */
    public static function registerPlugins(Event $composerEvent)
    {
    }
}
