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
     * @var \Rougin\Torin\Pages\Orders
     */
    protected $page;

    /**
     * @return void
     */
    public function test_should_render_orders_page_output()
    {
        $expect = $this->getPlate('Orders');

        $depot = new OrderDepot(new Order);

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

        $plate = $this->withPlate();

        $http = $this->withHttp();

        $this->page = new Orders($plate, $http);
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
