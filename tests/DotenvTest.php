<?php

namespace Rougin\Torin;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class DotenvTest extends Testcase
{
    /**
     * @return void
     */
    public function test_should_load_environment_variables()
    {
        // Define the fixture path ------------
        $path = __DIR__ . '/Fixture/Dotenv';
        // ------------------------------------

        // Load the environment variables ---
        Dotenv::load($path, '.env.example');
        // ----------------------------------

        $expects = array();

        $expects['TEST_NORMAL'] = 'NormalValue';
        $expects['TEST_QUOTED'] = 'Quoted Value';
        $expects['TEST_INLINE'] = 'InlineValue';
        $expects['TEST_EXPORT'] = 'ExportedValue';
        $expects['TEST_NESTED'] = 'NestedValue';

        // Assert the variables are correctly set ---
        foreach ($expects as $key => $value)
        {
            $this->assertEquals($value, $_ENV[$key]);
        }
        // ------------------------------------------
    }

    /**
     * @return void
     */
    public function test_should_not_load_if_file_not_found()
    {
        $this->doExpectedException('Exception');

        // Define a non-existent fixture path ---
        $path = __DIR__ . '/Fixture/Unknown';
        // --------------------------------------

        // Attempt to load the file --------
        Dotenv::load($path, '.env.example');
        // ---------------------------------
    }
}
