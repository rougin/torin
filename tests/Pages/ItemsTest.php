<?php

namespace Rougin\Torin\Pages;

use Rougin\Torin\Depots\ItemDepot;
use Rougin\Torin\Models\Item;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ItemsTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Pages\Items
     */
    protected $page;

    /**
     * @return void
     */
    public function test_page_output()
    {
        $expect = $this->getPlate('Items');

        $depot = new ItemDepot(new Item);

        $actual = $this->page->index($depot);

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

        $this->page = new Items($plate, $http);
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
