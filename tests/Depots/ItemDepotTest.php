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
    public function test_can_find_all_items()
    {
        $model = new Item;

        $model->create(['name' => 'Item A', 'detail' => 'Detail A']);
        $model->create(['name' => 'Item B', 'detail' => 'Detail B']);

        $items = $this->depot->all();

        $this->assertCount(2, $items);
        $this->assertEquals('Item A', $items[0]->name);
    }

    /**
     * @return void
     */
    public function test_can_create_item()
    {
        $data = ['name' => 'New Item', 'detail' => 'New Item Detail'];

        $item = $this->depot->create($data);

        $this->assertNotNull($item);
        $this->assertEquals('New Item', $item->name);
        $this->assertEquals('New Item Detail', $item->detail);
        $this->assertMatchesRegularExpression('/^00-\d{8}-\d{5}$/', $item->code);
        $this->assertEquals('00-' . date('Ymd') . '-00001', $item->code);
    }

    /**
     * @return void
     */
    public function test_can_get_items_for_select()
    {
        $this->depot->create(['name' => 'Item X', 'detail' => 'Detail X']);
        $this->depot->create(['name' => 'Item Y', 'detail' => 'Detail Y']);

        $items = $this->depot->getSelect();

        $this->assertCount(2, $items);
        $this->assertEquals(['value' => 1, 'label' => 'Item X'], $items[0]);
        $this->assertEquals(['value' => 2, 'label' => 'Item Y'], $items[1]);
    }

    /**
     * @return void
     */
    public function test_can_update_item()
    {
        $old = ['name' => 'Old Item Name', 'detail' => 'Old Item Detail'];

        $item = $this->depot->create($old);

        $new = ['name' => 'Updated Item Name', 'detail' => 'Updated Item Detail'];

        $result = $this->depot->update($item->id, $new);

        $this->assertTrue($result);

        $actual = $this->depot->find($item->id);

        $this->assertEquals('Updated Item Name', $actual->name);
        $this->assertEquals('Updated Item Detail', $actual->detail);
    }

    /**
     * @return void
     */
    public function test_can_find_item_with_orders_by_id()
    {
        $model = new Item;
        $item = $model->create(['name' => 'Item Z', 'detail' => 'Detail Z']);

        $data = array('code' => 'ORD-009');
        $data['type'] = Order::TYPE_PURCHASE;
        $data['status'] = Order::STATUS_COMPLETED;
        $model = new Order;
        $order = $model->create($data);
        $item->orders()->attach($order->id, ['quantity' => 10]);

        $actual = $this->depot->find($item->id);

        $this->assertNotNull($actual);
        $this->assertEquals('Item Z', $actual->name);
        $this->assertCount(1, $actual->orders);
        $this->assertEquals(10, $actual->quantity);
    }

    /**
     * @return void
     */
    public function test_can_generate_item_code_with_correct_format()
    {
        $today = date('Ymd');

        // Create first item
        $item1 = $this->depot->create(['name' => 'Item 1', 'detail' => 'Detail 1']);
        $this->assertMatchesRegularExpression('/^00-\d{8}-\d{5}$/', $item1->code);
        $this->assertEquals('00-' . $today . '-00001', $item1->code);

        // Create second item
        $item2 = $this->depot->create(['name' => 'Item 2', 'detail' => 'Detail 2']);
        $this->assertMatchesRegularExpression('/^00-\d{8}-\d{5}$/', $item2->code);
        $this->assertEquals('00-' . $today . '-00002', $item2->code);

        // Create third item
        $item3 = $this->depot->create(['name' => 'Item 3', 'detail' => 'Detail 3']);
        $this->assertMatchesRegularExpression('/^00-\d{8}-\d{5}$/', $item3->code);
        $this->assertEquals('00-' . $today . '-00003', $item3->code);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        parent::doSetUp();

        $this->depot = new ItemDepot(new Item);
    }
}
