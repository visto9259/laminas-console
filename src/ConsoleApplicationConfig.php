<?php

namespace Visto\Console;

use Laminas\Stdlib\AbstractOptions;

class ConsoleApplicationConfig extends AbstractOptions
{
    protected $__strictMode__ = false;

    protected string $name = 'Laminas Symfony Console';
    protected string $version = '1.0.0';
    protected array $commands = [];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ConsoleApplicationConfig
    {
        $this->name = $name;
        return $this;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): ConsoleApplicationConfig
    {
        $this->version = $version;
        return $this;
    }

    public function getCommands(): array
    {
        return $this->commands;
    }

    public function setCommands(array $commands): ConsoleApplicationConfig
    {
        $this->commands = $commands;
        return $this;
    }
}
