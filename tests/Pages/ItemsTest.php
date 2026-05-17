<?php

namespace Rougin\Torin\Pages;

use Rougin\Torin\Checks\ItemCheck;
use Rougin\Torin\Depots\ItemDepot;
use Rougin\Torin\Models\Item;
use Rougin\Torin\Plate;
use Rougin\Torin\Routes\Items;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ItemsTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Plate
     */
    protected $plate;

    /**
     * @var \Rougin\Torin\Routes\Items
     */
    protected $route;

    /**
     * @return void
     */
    public function test_should_render_items_page_output()
    {
        $expect = $this->findPlate('Items');

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

        $http = $this->withHttp('/items');

        // Add query parameters to the request ---
        $param = array('p' => 1, 'l' => 10);

        $http = $http->withQueryParams($param);
        // ---------------------------------------

        $plate = $this->getPlate();

        $this->plate = new Plate($plate, $http);

        $check = new ItemCheck;

        $depot = new ItemDepot(new Item);

        $this->route = new Items($check, $depot);
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
