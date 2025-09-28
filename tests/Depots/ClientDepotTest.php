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
