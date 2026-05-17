<?php

namespace Rougin\Torin\Pages;

use Rougin\Torin\Checks\ClientCheck;
use Rougin\Torin\Depots\ClientDepot;
use Rougin\Torin\Models\Client;
use Rougin\Torin\Plate;
use Rougin\Torin\Routes\Clients;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ClientsTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Plate
     */
    protected $plate;

    /**
     * @var \Rougin\Torin\Routes\Clients
     */
    protected $route;

    /**
     * @return void
     */
    public function test_passed_if_clients_page_rendered()
    {
        $expect = $this->findPlate('Clients');

        $actual = $this->route->page($this->plate);

        $actual = $this->parseHtml($actual);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->startUp();

        $this->migrate();

        $http = $this->withHttp('/clients');

        // Add query parameters to the request ---
        $param = array('p' => 1, 'l' => 10);

        $http = $http->withQueryParams($param);
        // ---------------------------------------

        $plate = $this->getPlate();

        $this->plate = new Plate($plate, $http);

        $check = new ClientCheck;

        $depot = new ClientDepot(new Client);

        $this->route = new Clients($check, $depot);
    }

    /**
     * @return void
     */
    protected function doTearDown()
    {
        $this->rollback();

        $this->shutdown();
    }
}
