<?php

namespace Rougin\Torin;

use Rougin\Slytherin\Routing\Router as Slytherin;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Router extends Slytherin
{
    /**
     * @var string
     */
    protected $namespace = 'Rougin\Torin\Routes';

    /**
     * @var string
     */
    protected $prefix = '/';

    /**
     * Returns a listing of available routes.
     *
     * @return \Rougin\Slytherin\Routing\RouteInterface[]
     */
    public function routes()
    {
        $this->get('/', 'Hello@index');

        return $this->routes;
    }
}
