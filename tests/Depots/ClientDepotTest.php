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
    public function test_passed_if_all_clients_found()
    {
        $model = new Client;

        // Create a new client ---------------
        $data = array('name' => 'Client A');

        $data['type'] = Client::TYPE_SUPPLIER;

        $model->create($data);
        // -----------------------------------

        // Create another new client ---------
        $data = array('name' => 'Client B');

        $data['type'] = Client::TYPE_CUSTOMER;

        $model->create($data);
        // -----------------------------------

        $items = $this->depot->all();

        // Check if "Client A" already created ---
        $expect = 'Client A';

        $actual = $items[0]->name;

        $this->assertEquals($expect, $actual);
        // ---------------------------------------

        // Check if "Client B" already created ---
        $expect = 'Client B';

        $actual = $items[1]->name;

        $this->assertEquals($expect, $actual);
        // ---------------------------------------
    }

    /**
     * @return void
     */
    public function test_passed_if_client_created()
    {
        // Create a new client as customer ---
        $data = array('name' => 'New Client');

        $data['type'] = Client::TYPE_CUSTOMER;

        $data['remarks'] = 'Some remarks';

        $actual = $this->depot->create($data);
        // -----------------------------------

        $expect = 'New Client';

        $this->assertEquals($expect, $actual->name);

        $this->assertEquals(0, $actual->type);

        $expect = 'Some remarks';

        $this->assertEquals($expect, $actual->remarks);
    }

    /**
     * @return void
     */
    public function test_passed_if_client_found_by_id()
    {
        $model = new Client;

        // Create a new client as supplier ---
        $data = array('name' => 'Client C');

        $data['type'] = Client::TYPE_SUPPLIER;

        $result = $model->create($data);
        // -----------------------------------

        $actual = $this->depot->find($result->id);

        $this->assertEquals('Client C', $actual->name);

        // Assert timestamp attributes -------
        $expect = date('d M Y h:i A', time());

        $stamp = $actual->created_at;

        $this->assertEquals($expect, $stamp);

        $stamp = $actual->getUpdatedAt();

        $this->assertEquals($expect, $stamp);
        // -----------------------------------
    }

    /**
     * @return void
     */
    public function test_passed_if_client_updated()
    {
        // Create a new client as customer ---
        $data = array('name' => 'Old Client');

        $data['type'] = Client::TYPE_CUSTOMER;

        $data['remarks'] = 'Some remarks';

        $client = $this->depot->create($data);
        // -----------------------------------

        // Update the recent client as supplier ---
        $data = array('name' => 'New Client');

        $data['type'] = Client::TYPE_SUPPLIER;

        $data['remarks'] = 'New remarks';

        $this->depot->update($client->id, $data);
        // ----------------------------------------

        $actual = $this->depot->find($client->id);

        $expect = 'New remarks';

        $this->assertEquals($expect, $actual->remarks);

        $expect = 'New Client';

        $this->assertEquals($expect, $actual->name);

        $expect = Client::TYPE_SUPPLIER;

        $this->assertEquals($expect, $actual->type);
    }

    /**
     * @return void
     */
    public function test_passed_if_clients_for_select()
    {
        // Create a new client as customer ---
        $data = array('name' => 'Client X');

        $data['type'] = Client::TYPE_CUSTOMER;

        $this->depot->create($data);
        // -----------------------------------

        // Create a new client as supplier ---
        $data = array('name' => 'Client Y');

        $data['type'] = Client::TYPE_SUPPLIER;

        $this->depot->create($data);
        // -----------------------------------

        $actual = $this->depot->getSelect();

        $expect = array('value' => 1, 'label' => 'Client X');

        $this->assertEquals($expect, $actual[0]);

        $expect = array('value' => 2, 'label' => 'Client Y');

        $this->assertEquals($expect, $actual[1]);
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
