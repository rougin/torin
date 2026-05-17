<?php

namespace Rougin\Torin\Pages;

use Rougin\Torin\Checks\OrderCheck;
use Rougin\Torin\Depots\OrderDepot;
use Rougin\Torin\Models\Order;
use Rougin\Torin\Plate;
use Rougin\Torin\Routes\Orders;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class OrdersTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Routes\Orders
     */
    protected $route;

    /**
     * @var \Rougin\Torin\Plate
     */
    protected $plate;

    /**
     * @return void
     */
    public function test_passed_if_orders_page_rendered()
    {
        $expect = $this->findPlate('Orders');

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

        $http = $this->withHttp('/orders');

        // Add query parameters to the request ---
        $param = array('p' => 1, 'l' => 10);

        $http = $http->withQueryParams($param);
        // ---------------------------------------

        $plate = $this->getPlate();

        $this->plate = new Plate($plate, $http);

        $check = new OrderCheck;

        $depot = new OrderDepot(new Order);

        $this->route = new Orders($check, $depot);
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
