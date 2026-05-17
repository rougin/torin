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
        $data = array('detail' => 'Descript');

        $check = new ItemCheck;

        $actual = $check->valid($data);

        $this->assertFalse($actual);

        $actual = $check->firstError();

        $expect = 'Name is required';

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_valid_data()
    {
        $data = array('name' => 'Another Item');

        $data['detail'] = 'Test Detail';

        $check = new ItemCheck;

        $this->assertTrue($check->valid($data));
    }
}
