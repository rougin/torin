<?php

namespace Rougin\Torin\Depots;

use Rougin\Torin\Testcase;
use Rougin\Torin\Models\Client;
use Illuminate\Database\Capsule\Manager as Capsule;

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
    public function test_can_find_all_clients()
    {
        $model = new Client;

        $model->create(['name' => 'Client A', 'type' => 1]);
        $model->create(['name' => 'Client B', 'type' => 1]);

        $clients = $this->depot->all();

        $this->assertCount(2, $clients);
        $this->assertEquals('Client A', $clients[0]->name);
    }

    /**
     * @return void
     */
    public function test_can_find_client_by_id()
    {
        $model = new Client;

        $current = time();

        $item = $model->create(['name' => 'Client C', 'type' => 1]);

        $actual = $this->depot->find($item->id);

        $this->assertNotNull($actual);
        $this->assertEquals('Client C', $actual->name);

        // Assert "getCreatedAtAttribute", "getUpdatedAtAttribute" ---
        $date = date('d M Y h:i A', $current);
        $this->assertEquals($date, $actual->created_at);
        $this->assertEquals($date, $actual->updated_at);
        // -----------------------------------------------------------
    }

    /**
     * @return void
     */
    public function test_can_create_client()
    {
        $data = ['name' => 'New Client', 'type' => 0, 'remarks' => 'Some remarks'];

        $client = $this->depot->create($data);

        $this->assertNotNull($client);
        $this->assertEquals('New Client', $client->name);
        $this->assertEquals(0, $client->type);
        $this->assertEquals('Some remarks', $client->remarks);
        $this->assertNotNull($client->code);
    }

    /**
     * @return void
     */
    public function test_can_get_clients_for_select()
    {
        $this->depot->create(['name' => 'Client X', 'type' => 0]);
        $this->depot->create(['name' => 'Client Y', 'type' => 1]);

        $items = $this->depot->getSelect();

        $this->assertCount(2, $items);
        $this->assertEquals(['value' => 1, 'label' => 'Client X'], $items[0]);
        $this->assertEquals(['value' => 2, 'label' => 'Client Y'], $items[1]);
    }

    /**
     * @return void
     */
    public function test_can_update_client()
    {
        $client = $this->depot->create(['name' => 'Old Client Name', 'type' => 0, 'remarks' => 'Old remarks']);

        $data = array('type' => 1);
        $data['name'] = 'Updated Client Name';
        $data['remarks'] = 'Updated remarks';

        $result = $this->depot->update($client->id, $data);

        $this->assertTrue($result);

        $actual = $this->depot->find($client->id);

        $this->assertEquals('Updated Client Name', $actual->name);
        $this->assertEquals(1, $actual->type);
        $this->assertEquals('Updated remarks', $actual->remarks);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        parent::doSetUp();

        $this->runPhinx('CreateClientsTable');

        $depot = new ClientDepot(new Client);

        $this->depot = $depot;
    }

    /**
     * @return void
     */
    protected function doTearDown()
    {
        Capsule::schema('torin')->drop('clients');

        parent::doTearDown();
    }
}
