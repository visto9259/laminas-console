<?php

namespace Visto\Console\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Visto\Console\ConsoleApplicationConfig;
use Visto\Console\ContainerCommandLoader;

class ConsoleApplicationFactory implements FactoryInterface
{

    /**
     * Create a Symfony Console
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Application
    {
        $config = $container->get('config');
        $laminasConsoleConfig = new ConsoleApplicationConfig(
            $config['laminas-console'] ?? []
        );
        $containerCommandLoader = new ContainerCommandLoader(
            $container,
            $laminasConsoleConfig->getCommands()
        );

        $application = new Application();
        $application->setName($laminasConsoleConfig->getName());
        $application->setVersion($laminasConsoleConfig->getVersion());
        $application->setCommandLoader($containerCommandLoader);
        $application->setAutoExit(false);
        return $application;
    }
}
