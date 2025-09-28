<?php

namespace Rougin\Torin\Depots;

use Rougin\Torin\Models\Client;
use Rougin\Torin\Models\Item;
use Rougin\Torin\Models\Order;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class OrderDepotTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Depots\OrderDepot
     */
    protected $depot;

    /**
     * @return void
     */
    public function test_change_order_status()
    {
        $model = new Client;
        $client = $model->create(['name' => 'Jane Doe', 'type' => 1]);

        $model = new Item;
        $item = $model->create(['name' => 'Item 2', 'price' => 200]);

        $data = array('remarks' => null);
        $data['client_id'] = $client->id;
        $data['type'] = Order::TYPE_PURCHASE;
        $cart = array('id' => $item->id, 'quantity' => 20);
        $data['cart'] = array($cart);

        $order = $this->depot->create($data);

        $this->depot->changeStatus($order->id, Order::STATUS_COMPLETED);

        $result = $this->depot->find($order->id);

        $this->assertEquals(Order::STATUS_COMPLETED, $result->status);
    }

    /**
     * @return void
     */
    public function test_create_order()
    {
        $model = new Client;
        $client = $model->create(['name' => 'John Doe', 'type' => 1]);

        $model = new Item;
        $item = $model->create(['name' => 'Item 1', 'price' => 100]);

        $data = array('remarks' => 'Test remarks');
        $data['client_id'] = $client->id;
        $data['type'] = Order::TYPE_PURCHASE;
        $cart = array('id' => $item->id, 'quantity' => 10);
        $data['cart'] = array($cart);

        $order = $this->depot->create($data);

        $this->depot->changeStatus($order->id, Order::STATUS_COMPLETED);

        $actual = $this->depot->find($order->id);

        $this->assertNotNull($actual->id);
        $this->assertEquals($client->id, $actual->client_id);
        $this->assertEquals('Test remarks', $actual->remarks);

        $this->assertCount(1, $actual->items);
        $this->assertEquals(10, $actual->items[0]->quantity);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        parent::doSetUp();

        $this->depot = new OrderDepot(new Order);
    }
}
