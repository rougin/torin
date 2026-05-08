<?php

namespace Rougin\Torin\Checks;

use Rougin\Torin\Models\Client;
use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ClientCheckTest extends Testcase
{
    /**
     * @return void
     */
    public function test_failed_if_field_is_required()
    {
        $data = array('name' => 'John Doe');

        $expect = 'Client Type is required';

        $check = new ClientCheck;

        $actual = $check->valid($data);

        $this->assertFalse($actual);

        $actual = $check->firstError();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_valid_data()
    {
        $data = array('name' => 'John Doe');

        $data['type'] = Client::TYPE_CUSTOMER;

        $check = new ClientCheck;

        $actual = $check->valid($data);

        $this->assertTrue($actual);
    }
}
