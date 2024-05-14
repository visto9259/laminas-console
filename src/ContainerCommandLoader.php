<?php

namespace Visto\Console;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Webmozart\Assert\Assert;

class ContainerCommandLoader implements CommandLoaderInterface
{
    private array $commands = [];

    public function __construct(private ContainerInterface $container, array $commands)
    {
        Assert::isMap($commands);
        $this->commands = $commands;
    }
    /**
     * @inheritDoc
     */
    public function get(string $name): Command
    {
        if ($this->container->has($this->commands[$name])) {
            return $this->fetchCommandFromContainer($name);
        }

        $class = $this->commands[$name];
        Assert::classexists($class, sprintf('Command "%s" maps to class "%s", which does not exist', $name, $class));
        Assert::subclassOf($class, Command::class, sprintf(
            'Command "%s" maps to class "%s", which does not extend %s',
            $name,
            $class,
            Command::class
        ));

        // Command does not have a factory and must be instantiated
        return $this->createCommand($this->commands[$name], $name);
    }

    /**
     * @inheritDoc
     */
    public function has(string $name): bool
    {
        if (! array_key_exists($name, $this->commands)) {
            return false;
        }

        if (is_string($this->commands[$name]) && $this->container->has($this->commands[$name])) {
            return true;
        } // TODO add the case where command is an array

        return isset($this->commands[$name]);
    }

    /**
     * @inheritDoc
     */
    public function getNames(): array
    {
        return array_keys($this->commands);
    }

    private function createCommand(string $class, string $name): Command
    {
        $command = new $class();
        $command->setName($name);
        return $command;
    }

    private function fetchCommandFromContainer( string $name): Command
    {
        $command = $this->container->get($this->commands[$name]);
        Assert::isInstanceOf($command, Command::class, sprintf(
            'Command "%s" maps to a class which does not extend %s',
            $name,
            Command::class
        ));
        $command->setName($name);
        return $command;
    }
}
