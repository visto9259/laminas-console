<?php

namespace Visto\Console;

use Psr\Container\ContainerInterface;
use Webmozart\Assert\Assert;

class ContainerResolver
{
    public function __construct(private string $projectRoot)
    {
    }

    public function resolve(): ContainerInterface
    {
        $mezzioContainer = sprintf('%s/config/container.php', $this->projectRoot);
        if (file_exists($mezzioContainer)) {
            return $this->resolveContainerFromAbsolutePath($mezzioContainer);
        }

        /** TODO Add Mvc Resolver? */

        throw new \RuntimeException(
            'Cannot detect PSR-11 container to configure the laminas-console application.'
        );
    }

    private function resolveContainerFromAbsolutePath(string $containerPath): ContainerInterface
    {
        if (! file_exists($containerPath)) {
            throw new \InvalidArgumentException(
                sprintf('Provided container path could not be resolved to an existing file: %s',
                $containerPath)
            );
        }
        $container = include $containerPath;
        Assert::isInstanceOf($container, ContainerInterface::class, 'Failed to load PSR-11 container.');

        return $container;
    }
}
