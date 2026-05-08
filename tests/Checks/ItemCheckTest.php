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
     * @return void
     */
    public function test_failed_if_field_is_required()
    {
        $data = array('detail' => 'Descrip');

        $expect = 'Name is required';

        $check = new ItemCheck;

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
        $data = array('name' => 'Test Item');

        $data['detail'] = 'Test Detail';

        $check = new ItemCheck;

        $actual = $check->valid($data);

        $this->assertTrue($actual);
    }
}
