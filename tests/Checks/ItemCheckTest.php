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
     * @var \Rougin\Torin\Checks\ItemCheck
     */
    protected $check;

    /**
     * @return mixed[][]
     */
    public function for_errors_provider()
    {
        $items = array();

        $item = array();
        $item[] = array('detail' => 'Test Detail');
        $item[] = 'Name is required';
        $items[] = $item;

        $item = array();
        $item[] = array('name' => 'Test Item');
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
        $actual = $this->check->valid($data);

        $this->assertFalse($actual);

        $actual = $this->check->firstError();

        $this->assertEquals($text, $actual);
    }

    /**
     * @return void
     */
    public function test_for_passed_check()
    {
        $data = array('name' => 'Test Item');
        $data['detail'] = 'Test Detail';

        $actual = $this->check->valid($data);

        $this->assertTrue($actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        parent::doSetUp();

        $this->check = new ItemCheck;
    }
}
