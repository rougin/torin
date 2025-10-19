<?php

namespace Rougin\Torin\Depots;

use Rougin\Torin\Testcase;
use Rougin\Torin\Models\Client;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ClientDepotTest extends Testcase
{
    /**
     * @var \Rougin\Torin\Depots\ClientDepot
     */
    protected $depot;

    /**
     * @return void
     */
    public function test_should_find_all_clients()
    {
        $model = new Client;

        $data = array('name' => 'Client A');
        $data['type'] = Client::TYPE_SUPPLIER;
        $model->create($data);

        $data = array('name' => 'Client B');
        $data['type'] = Client::TYPE_CUSTOMER;
        $model->create($data);

        $items = $this->depot->all();
        $actual = $items[0]->name;

        $this->assertEquals('Client A', $actual);
    }

    /**
     * @return void
     */
    public function test_should_find_client_by_id()
    {
        $model = new Client;

        $data = array('name' => 'Client C');
        $data['type'] = Client::TYPE_SUPPLIER;
        $result = $model->create($data);

        $actual = $this->depot->find($result->id);

        $this->assertEquals('Client C', $actual->name);

        // Assert timestamp attributes -------
        $expect = date('d M Y h:i A', time());

        $stamp = $actual->created_at;
        $this->assertEquals($expect, $stamp);

        $stamp = $actual->updated_at;
        $this->assertEquals($expect, $stamp);
        // -----------------------------------
    }

    /**
     * @return void
     */
    public function test_should_create_client()
    {
        $data = array('name' => 'New Client');
        $data['type'] = Client::TYPE_CUSTOMER;
        $data['remarks'] = 'Some remarks';
        $actual = $this->depot->create($data);

        $this->assertEquals('New Client', $actual->name);
        $this->assertEquals(0, $actual->type);
        $this->assertEquals('Some remarks', $actual->remarks);
    }

    /**
     * @return void
     */
    public function test_should_get_clients_for_select_input()
    {
        $data = array('name' => 'Client X');
        $data['type'] = Client::TYPE_CUSTOMER;
        $this->depot->create($data);

        $data = array('name' => 'Client Y');
        $data['type'] = Client::TYPE_SUPPLIER;
        $this->depot->create($data);

        $actual = $this->depot->getSelect();

        $expected = array('value' => 1, 'label' => 'Client X');
        $this->assertEquals($expected, $actual[0]);

        $expected = array('value' => 2, 'label' => 'Client Y');
        $this->assertEquals($expected, $actual[1]);
    }

    /**
     * @return void
     */
    public function test_should_update_client()
    {
        $data = array('name' => 'Old Client');
        $data['type'] = Client::TYPE_CUSTOMER;
        $data['remarks'] = 'Some remarks';
        $client = $this->depot->create($data);

        $data = array('name' => 'New Client');
        $data['type'] = Client::TYPE_SUPPLIER;
        $data['remarks'] = 'New remarks';
        $this->depot->update($client->id, $data);

        $actual = $this->depot->find($client->id);

        $this->assertEquals('New Client', $actual->name);
        $this->assertEquals(Client::TYPE_SUPPLIER, $actual->type);
        $this->assertEquals('New remarks', $actual->remarks);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->startUp();

        $this->migrate();

        $this->depot = new ClientDepot(new Client);
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
