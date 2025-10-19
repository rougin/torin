<?php

namespace Rougin\Torin;

use Rougin\Slytherin\Container\ContainerInterface;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Integration\IntegrationInterface;
use Rougin\Slytherin\Routing\RouterInterface;
use Staticka\Render;
use Staticka\Render\RenderInterface;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Package implements IntegrationInterface
{
    /**
     * @param \Rougin\Slytherin\Container\ContainerInterface $app
     * @param \Rougin\Slytherin\Integration\Configuration    $config
     *
     * @return \Rougin\Slytherin\Container\ContainerInterface
     */
    public function define(ContainerInterface $app, Configuration $config)
    {
        // Initialize the "RenderInterface" ---
        /** @var string|string[] */
        $path = $config->get('app.views', '');

        $self = new Render($path);

        $name = RenderInterface::class;

        $app = $app->set($name, $self);
        // ------------------------------------

        // @codeCoverageIgnoreStart ------------
        if (! $app->has(RouterInterface::class))
        {
            return $app;
        }
        // @codeCoverageIgnoreEnd --------------

        // Initialize the "RouterInterface" ------
        $self = new Router;

        $temp = $app->get(RouterInterface::class);

        // @codeCoverageIgnoreStart -----------
        if (! $temp instanceof RouterInterface)
        {
            return $app;
        }
        // @codeCoverageIgnoreEnd -------------

        $self = $temp->merge($self->routes());
        // ---------------------------------------

        return $app->set(RouterInterface::class, $self);
    }
}
