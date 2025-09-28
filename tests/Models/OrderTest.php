<?php

namespace Rougin\Torin\Models;

use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class OrderTest extends Testcase
{
    /**
     * @return void
     */
    public function test_create_order()
    {
        $model = new Client;
        $client = $model->create(['name' => 'John Doe', 'type' => 1]);

        $data = array('type' => Order::TYPE_PURCHASE);
        $data['client_id'] = $client->id;
        $data['code'] = '1-20240101-00001';
        $data['status'] = Order::STATUS_PENDING;

        $model = new Order;
        $order = $model->create($data);

        $this->assertNotNull($order->id);
        $this->assertEquals($client->id, $order->client_id);
    }

    /**
     * @return void
     */
    public function test_find_order()
    {
        $model = new Client;
        $client = $model->create(['name' => 'Jane Doe', 'type' => 1]);

        $data = array('type' => Order::TYPE_PURCHASE);
        $data['client_id'] = $client->id;
        $data['code'] = '1-20240101-00002';
        $data['status'] = Order::STATUS_PENDING;

        $model = new Order;
        $order = $model->create($data);

        $actual = $model->find($order->id);

        $this->assertNotNull($actual);
        $this->assertEquals($order->id, $actual->id);
        $this->assertEquals($client->id, $actual->client_id);
    }
}
