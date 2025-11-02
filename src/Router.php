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
    protected $prefix = '/v1';

    /**
     * @return \Rougin\Slytherin\Routing\RouteInterface[]
     */
    public function routes()
    {
        // Client --------------------------------------
        $this->get('/clients/select', 'Clients@select');

        $this->delete('/clients/:id', 'Clients@delete');

        $this->get('/clients', 'Clients@index');

        $this->put('/clients/:id', 'Clients@update');

        $this->post('/clients', 'Clients@store');
        // ---------------------------------------------

        // Item ------------------------------------
        $this->get('/items/select', 'Items@select');

        $this->delete('/items/:id', 'Items@delete');

        $this->get('/items', 'Items@index');

        $this->put('/items/:id', 'Items@update');

        $this->post('/items', 'Items@store');
        // -----------------------------------------

        // Order ------------------------------------------
        $this->delete('/orders/:id', 'Orders@delete');

        $this->post('/orders/:id/status', 'Orders@status');

        $this->get('/orders', 'Orders@index');

        $this->post('/orders/check', 'Orders@check');

        $this->post('/orders', 'Orders@store');
        // ------------------------------------------------

        $this->pages();

        return $this->routes;
    }

    /**
     * @return void
     */
    protected function pages()
    {
        $this->prefix('/', 'Rougin\Torin\Pages');

        $this->get('/', 'Hello@index');

        $this->get('clients', 'Clients@index');

        $this->get('items', 'Items@index');

        $this->get('orders', 'Orders@index');
    }
}
