<?php

namespace Visto\Console;

use Symfony\Component\Console\Application;
use Visto\Console\Factory\ConsoleApplicationFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'factories' => [
                Application::class => ConsoleApplicationFactory::class,
            ],
        ];
    }
}
