<?php

namespace Rougin\Torin\Models;

use Rougin\Torin\Testcase;

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

        $client = $model->create(['name' => 'John Doe', 'type' => 1]);

        $this->assertNotNull($client->id);
        $this->assertEquals('John Doe', $client->name);
    }

    /**
     * @return void
     */
    public function test_can_find_a_client()
    {
        $model = new Client;

        $model->create(['name' => 'Jane Doe', 'type' => 1]);

        $client = $model->where('name', 'Jane Doe')->first();

        $this->assertNotNull($client);
        $this->assertEquals('Jane Doe', $client->name);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        parent::doSetUp();

        $this->migrate();
    }

    /**
     * @return void
     */
    protected function doTearDown()
    {
        $this->rollback();

        parent::doTearDown();
    }
}
