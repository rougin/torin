<?php

namespace Rougin\Torin\Depots;

use Rougin\Torin\Testcase;
use Rougin\Torin\Models\Item;
use Rougin\Torin\Models\Order;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ItemDepotTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Depots\ItemDepot
     */
    protected $depot;

    /**
     * @return void
     */
    public function test_should_find_all_items()
    {
        $model = new Item;

        $data = array('name' => 'Item A');
        $data['detail'] = 'Detail A';
        $model->create($data);

        $data = array('name' => 'Item B');
        $data['detail'] = 'Detail B';
        $model->create($data);

        $actual = $this->depot->all();

        $this->assertEquals('Item A', $actual[0]->name);
    }

    /**
     * @return void
     */
    public function test_should_create_item()
    {
        $data = array('name' => 'New Item');
        $data['detail'] = 'New Item Detail';
        $actual = $this->depot->create($data);

        $expect = 'New Item';
        $this->assertEquals($expect, $actual->name);

        $expect = 'New Item Detail';
        $this->assertEquals($expect, $actual->detail);

        $expect = '00-' . date('Ymd') . '-00001';
        $this->assertEquals($expect, $actual->code);

        $regex = '/^00-\d{8}-\d{5}$/';
        $this->assertRegex($regex, $actual->code);
    }

    /**
     * @return void
     */
    public function test_should_get_items_for_select_input()
    {
        $data = array('name' => 'Item X');
        $data['detail'] = 'Detail X';
        $this->depot->create($data);

        $data = array('name' => 'Item Y');
        $data['detail'] = 'Detail Y';
        $this->depot->create($data);

        $actual = $this->depot->getSelect();

        $expect = array('value' => 1, 'label' => 'Item X');
        $this->assertEquals($expect, $actual[0]);

        $expect = array('value' => 2, 'label' => 'Item Y');
        $this->assertEquals($expect, $actual[1]);
    }

    /**
     * @return void
     */
    public function test_should_update_item()
    {
        $data = array('name' => 'Old Item Name');
        $data['detail'] = 'Old Item Description';
        $item = $this->depot->create($data);

        $data = array('name' => 'Updated Item Name');
        $data['detail'] = 'Updated Item Description';
        $this->depot->update($item->id, $data);

        $actual = $this->depot->find($item->id);

        $expect = 'Updated Item Description';
        $this->assertEquals($expect, $actual->detail);

        $expect = 'Updated Item Name';
        $this->assertEquals($expect, $actual->name);
    }

    /**
     * @return void
     */
    public function test_should_find_item_with_orders_by_id()
    {
        $model = new Item;

        $data = array('name' => 'Item Z');
        $data['detail'] = 'Detail Z';
        $item = $model->create($data);

        // Create a new order with an item --------
        $model = new Order;

        $data = array('code' => 'ORD-009');
        $data['type'] = Order::TYPE_PURCHASE;
        $data['status'] = Order::STATUS_COMPLETED;
        $order = $model->create($data);

        $data = array('quantity' => 10);
        $item->orders()->attach($order->id, $data);
        // ----------------------------------------

        $actual = $this->depot->find($item->id);

        $this->assertEquals('Item Z', $actual->name);
        $this->assertEquals(10, $actual->quantity);
    }

    /**
     * @return void
     */
    public function test_should_generate_item_code_with_correct_format()
    {
        $pattern = '/^00-\d{8}-\d{5}$/';

        $today = date('Ymd');

        // Create the first item ------------------
        $data = array('name' => 'Item 1');
        $data['detail'] = 'Detail 1';
        $item1 = $this->depot->create($data);

        $this->assertRegex($pattern, $item1->code);

        $expect = '00-' . $today . '-00001';
        $this->assertEquals($expect, $item1->code);
        // ----------------------------------------

        // Create the first item ------------------
        $data = array('name' => 'Item 2');
        $data['detail'] = 'Detail 2';
        $item2 = $this->depot->create($data);

        $this->assertRegex($pattern, $item2->code);

        $expect = '00-' . $today . '-00002';
        $this->assertEquals($expect, $item2->code);
        // ----------------------------------------

        // Create the first item ------------------
        $data = array('name' => 'Item 3');
        $data['detail'] = 'Detail 3';
        $item3 = $this->depot->create($data);

        $this->assertRegex($pattern, $item3->code);

        $expect = '00-' . $today . '-00003';
        $this->assertEquals($expect, $item3->code);
        // ----------------------------------------
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->startUp();

        $this->migrate();

        $this->depot = new ItemDepot(new Item);
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
