<?php

namespace Visto\Console;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Application;

class ConsoleApplication
{
    /**
     * Creates a Symfony Console Application
     * @param ContainerInterface $container
     * @return Application
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function create(ContainerInterface $container): Application
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
