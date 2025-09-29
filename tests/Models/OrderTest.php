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

        $data = array('name' => 'John Doe');
        $data['type'] = Client::TYPE_SUPPLIER;
        $client = $model->create($data);

        $model = new Order;

        $data = array('type' => Order::TYPE_PURCHASE);
        $data['client_id'] = $client->id;
        $data['code'] = '1-20240101-00001';
        $data['status'] = Order::STATUS_PENDING;
        $actual = $model->create($data)->client_id;

        $this->assertEquals($client->id, $actual);
    }

    /**
     * @return void
     */
    public function test_find_order()
    {
        $model = new Client;

        $data = array('name' => 'Jane Doe');
        $data['type'] = Client::TYPE_SUPPLIER;
        $client = $model->create($data);

        $model = new Order;

        $data = array('type' => Order::TYPE_PURCHASE);
        $data['client_id'] = $client->id;
        $data['code'] = '1-20240101-00002';
        $data['status'] = Order::STATUS_PENDING;
        $order = $model->create($data);

        $actual = $model->find($order->id);
        $this->assertNotNull($actual);

        $actual = $actual->client_id;
        $this->assertEquals($client->id, $actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->startUp();

        $this->migrate();
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
