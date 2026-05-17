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
    public function test_passed_if_order_created()
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

        // Add the new item to the cart ---
        $cart = array('id' => $item->id);

        $cart['quantity'] = 10;
        // --------------------------------

        // Create a new purchase order ------------
        $data = array('remarks' => 'Test remarks');

        $data['created_by'] = 1; // Sample user

        $data['client_id'] = $client->id;

        $data['type'] = Order::TYPE_PURCHASE;

        $data['cart'] = array($cart);

        $order = $this->depot->create($data, 1);
        // ----------------------------------------

        $this->depot->setAsCompleted($order->id);

        $actual = $this->depot->find($order->id);

        $first = $actual->items[0];

        $this->assertEquals(10, $first->quantity);

        $value = $actual->client_id;

        $this->assertEquals($client->id, $value);

        $expect = 'Test remarks';

        $this->assertEquals($expect, $actual->remarks);
    }

    /**
     * @return void
     */
    public function test_passed_if_order_status_changed()
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

        // Add the new item to the cart ---
        $cart = array('id' => $item->id);

        $cart['quantity'] = 20;
        // --------------------------------

        // Create a new purchase order ------
        $data = array('remarks' => null);

        $data['client_id'] = $client->id;

        $data['type'] = Order::TYPE_PURCHASE;

        $data['cart'] = array($cart);

        $order = $this->depot->create($data);
        // ----------------------------------

        $this->depot->setAsCompleted($order->id);

        $result = $this->depot->find($order->id);

        $expect = Order::STATUS_COMPLETED;

        $actual = $result->status;

        $this->assertEquals($expect, $actual);
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
