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
     * @return void
     */
    public function test_page_output()
    {
        $depot = new ItemDepot(new Item);

        $page = new Items($this->plate, $this->request);

        $expect = $this->getPlate('Items');

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
