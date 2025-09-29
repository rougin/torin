<?php

namespace Rougin\Torin\Checks;

use Rougin\Torin\Testcase;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ItemCheckTest extends Testcase
{
    /**
     * @return mixed[][]
     */
    public function for_errors_provider()
    {
        $items = array();

        $data = array('detail' => 'Descrip');
        $item = array($data);
        $item[] = 'Name is required';
        $items[] = $item;

        $data = array('name' => 'Test Item');
        $item = array($data);
        $item[] = 'Description is required';
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
        $check = new ItemCheck;

        $this->assertFalse($check->valid($data));

        $actual = $check->firstError();

        $this->assertEquals($text, $actual);
    }

    /**
     * @return void
     */
    public function test_for_passed()
    {
        $data = array('name' => 'Test Item');
        $data['detail'] = 'Test Detail';

        $check = new ItemCheck;

        $actual = $check->valid($data);

        $this->assertTrue($actual);
    }
}
