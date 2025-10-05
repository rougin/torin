<?php

namespace Rougin\Torin\Pages;

use Rougin\Torin\Depots\OrderDepot;
use Rougin\Torin\Models\Order;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class OrdersTest extends Testcase
{
    /**
     * @return void
     */
    public function test_page_output()
    {
        $depot = new OrderDepot(new Order);

        $page = new Orders($this->plate, $this->request);

        $expect = $this->getPlate('Orders');

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
