<?php

namespace Rougin\Torin\Models;

use Rougin\Torin\Testcase;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ClientTest extends Testcase
{
    /**
     * @return void
     */
    public function test_can_create_a_client()
    {
        $model = new Client;

        $client = $model->create(['name' => 'John Doe', 'email' => 'john.doe@example.com']);

        $this->assertNotNull($client->id);
        $this->assertEquals('John Doe', $client->name);
    }

    /**
     * @return void
     */
    public function test_can_find_a_client()
    {
        $model = new Client;

        $model->create(['name' => 'Jane Doe', 'email' => 'jane.doe@example.com']);

        $client = $model->where('email', 'jane.doe@example.com')->first();

        $this->assertNotNull($client);
        $this->assertEquals('Jane Doe', $client->name);
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
