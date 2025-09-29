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
     * @return mixed[][]
     */
    public function for_errors_provider()
    {
        $items = array();

        $data = array('type' => Client::TYPE_CUSTOMER);
        $item = array($data);
        $item[] = 'Client Name is required';
        $items[] = $item;

        $data = array('name' => 'John Doe');
        $item = array($data);
        $item[] = 'Client Type is required';
        $items[] = $item;

        return $items;
    }

    /**
     * @dataProvider for_errors_provider
     *
     * @param array<string, string> $data
     * @param string                $text
     *
     * @return void
     */
    public function test_for_errors($data, $text)
    {
        $check = new ClientCheck;

        $this->assertFalse($check->valid($data));

        $actual = $check->firstError();

        $this->assertEquals($text, $actual);
    }

    /**
     * @return void
     */
    public function test_for_passed()
    {
        $data = array('name' => 'John Doe');
        $data['type'] = Client::TYPE_CUSTOMER;

        $check = new ClientCheck;

        $actual = $check->valid($data);

        $this->assertTrue($actual);
    }
}
