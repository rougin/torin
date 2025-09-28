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

        $model->create(['name' => 'Client A', 'email' => 'a@example.com']);
        $model->create(['name' => 'Client B', 'email' => 'b@example.com']);

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

        $item = $model->create(['name' => 'Client C', 'email' => 'c@example.com']);

        $actual = $this->depot->find($item->id);

        $this->assertNotNull($actual);
        $this->assertEquals('Client C', $actual->name);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        parent::doSetUp();

        Capsule::schema('torin')->create('clients', function ($table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        $this->depot = new ClientDepot(new Client);
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
