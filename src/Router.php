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
    protected $namespace = 'Rougin\Torin';

    /**
     * @var string
     */
    protected $prefix = '/';

    /**
     * @return \Rougin\Slytherin\Routing\RouteInterface[]
     */
    public function routes()
    {
        $this->pages();

        // Client ------------------------------------------------
        $this->get('/v1/clients/select', 'Routes\Clients@select');

        $this->delete('/v1/clients/:id', 'Routes\Clients@delete');

        $this->get('/v1/clients', 'Routes\Clients@index');

        $this->put('/v1/clients/:id', 'Routes\Clients@update');

        $this->post('/v1/clients', 'Routes\Clients@store');
        // -------------------------------------------------------

        // Item ----------------------------------------------
        $this->get('/v1/items/select', 'Routes\Items@select');

        $this->delete('/v1/items/:id', 'Routes\Items@delete');

        $this->get('/v1/items', 'Routes\Items@index');

        $this->put('/v1/items/:id', 'Routes\Items@update');

        $this->post('/v1/items', 'Routes\Items@store');
        // ---------------------------------------------------

        // Order ----------------------------------------------------
        $this->delete('/v1/orders/:id', 'Routes\Orders@delete');

        $this->post('/v1/orders/:id/status', 'Routes\Orders@status');

        $this->get('/v1/orders', 'Routes\Orders@index');

        $this->post('/v1/orders/check', 'Routes\Orders@check');

        $this->post('/v1/orders', 'Routes\Orders@store');
        // ----------------------------------------------------------

        return $this->routes;
    }

    /**
     * @return void
     */
    protected function pages()
    {
        $this->get('/', 'Pages\Hello@index');

        $this->get('clients', 'Pages\Clients@index');

        $this->get('items', 'Pages\Items@index');

        $this->get('orders', 'Pages\Orders@index');
    }
}
