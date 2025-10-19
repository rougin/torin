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
    public function test_should_change_order_status()
    {
        // Create a new client ---------------
        $model = new Client;

        $data = array('name' => 'Jane Doe');
        $data['type'] = Client::TYPE_SUPPLIER;
        $client = $model->create($data);
        // -----------------------------------

        // Create a new item -------------
        $model = new Item;

        $data = array('name' => 'Item 2');
        $data['price'] = 200;
        $item = $model->create($data);
        // -------------------------------

        // Add a new item to cart -----------
        $data = array('remarks' => null);
        $data['client_id'] = $client->id;
        $data['type'] = Order::TYPE_PURCHASE;

        $cart = array('id' => $item->id);
        $cart['quantity'] = 20;
        $data['cart'] = array($cart);

        $order = $this->depot->create($data);
        // ----------------------------------

        $status = Order::STATUS_COMPLETED;
        $this->depot->changeStatus($order->id, $status);

        $result = $this->depot->find($order->id);

        $expect = Order::STATUS_COMPLETED;
        $this->assertEquals($expect, $result->status);
    }

    /**
     * @return void
     */
    public function test_should_create_order()
    {
        // Create a new client ---------------
        $model = new Client;

        $data = array('name' => 'John Doe');
        $data['type'] = Client::TYPE_SUPPLIER;
        $client = $model->create($data);
        // -----------------------------------

        // Create a new item -------------
        $model = new Item;

        $data = array('name' => 'Item 1');
        $data['price'] = 100;
        $item = $model->create($data);
        // -------------------------------

        // Add a new item to cart -----------------
        $data = array('remarks' => 'Test remarks');
        $data['created_by'] = 1; // Sample user
        $data['client_id'] = $client->id;
        $data['type'] = Order::TYPE_PURCHASE;

        $cart = array('id' => $item->id);
        $cart['quantity'] = 10;
        $data['cart'] = array($cart);

        $order = $this->depot->create($data, 1);
        // ----------------------------------------

        $status = Order::STATUS_COMPLETED;
        $this->depot->changeStatus($order->id, $status);

        $actual = $this->depot->find($order->id);

        $this->assertEquals($client->id, $actual->client_id);
        $this->assertEquals('Test remarks', $actual->remarks);
        $this->assertEquals(10, $actual->items[0]->quantity);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->startUp();

        $this->migrate();

        $this->depot = new OrderDepot(new Order);
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
