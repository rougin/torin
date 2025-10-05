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
     * @return void
     */
    public function test_page_output()
    {
        $depot = new ClientDepot(new Client);

        $page = new Clients($this->plate, $this->request);

        $expect = $this->getPlate('Clients');

        $actual = $page->index($depot);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->startUp();
        $this->migrate();

        $this->withPlate();
        $this->withHttp();
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
