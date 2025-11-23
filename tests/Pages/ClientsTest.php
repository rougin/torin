<?php

namespace Rougin\Torin\Pages;

use Rougin\Torin\Depots\ClientDepot;
use Rougin\Torin\Models\Client;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ClientsTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Pages\Clients
     */
    protected $page;

    /**
     * @return void
     */
    public function test_should_render_clients_page_output()
    {
        $depot = new ClientDepot(new Client);

        $expect = $this->getPlate('Clients');

        $actual = $this->page->index($depot);

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

        $plate = $this->withPlate();

        // Add query parameters to the request ---
        $param = array('p' => 1, 'l' => 10);

        $http = $http->withQueryParams($param);
        // ---------------------------------------

        $page = new Clients($plate, $http);

        $this->page = $page;
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
