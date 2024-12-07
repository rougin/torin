<?php

namespace Rougin\Torin;

use Rougin\Slytherin\Container\ContainerInterface;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Integration\IntegrationInterface;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
abstract class Package implements IntegrationInterface
{
    /**
     * @param \Rougin\Slytherin\Container\ContainerInterface $container
     * @param \Rougin\Slytherin\Integration\Configuration    $config
     *
     * @return \Rougin\Slytherin\Container\ContainerInterface
     */
    public function define(ContainerInterface $container, Configuration $config)
    {
        $current = $this->setRouter();

        $interface = 'Rougin\Slytherin\Routing\RouterInterface';

        if ($container->has($interface))
        {
            /** @var \Rougin\Slytherin\Routing\RouterInterface */
            $router = $container->get($interface);

            $current = $router->merge($current->routes());
        }

        return $container->set($interface, $current);
    }

    /**
     * @return \Rougin\Slytherin\Routing\RouterInterface
     */
    abstract protected function setRouter();
}
