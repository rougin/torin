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
    public function test_failed_if_file_empty()
    {
        $this->doExpectException('Exception');

        // Define the fixture path ------------
        $path = __DIR__ . '/Fixture/Dotenv';
        // ------------------------------------

        // Attempt to load the file --------
        Dotenv::load($path, '.env.empty');
        // ---------------------------------
    }

    /**
     * @return void
     */
    public function test_failed_if_file_not_found()
    {
        $this->doExpectException('Exception');

        // Define a non-existent fixture path ---
        $path = __DIR__ . '/Fixture/Unknown';
        // --------------------------------------

        // Attempt to load the file --------
        Dotenv::load($path, '.env.example');
        // ---------------------------------
    }

    /**
     * @return void
     */
    public function test_passed_if_data_loaded()
    {
        // Load the environment variables ---
        $_SERVER['TEST_VALUE'] = 'Value';

        $path = __DIR__ . '/Fixture/Dotenv';

        Dotenv::load($path, '.env.example');
        // ----------------------------------

        // Define available data from ".env.example" -----
        $expects = array();

        $expects['TEST_NORMAL'] = 'NormalValue';
        $expects['TEST_QUOTED'] = 'Quoted Value';
        $expects['TEST_INLINE'] = 'InlineValue';
        $expects['TEST_EXPORT'] = 'ExportedValue';
        $expects['TEST_NESTED'] = 'NestedValue';
        $expects['TEST_EMPTY'] = '';
        $expects['TEST_UNRESOLVED'] = '${DOES_NOT_EXIST}';
        // -----------------------------------------------

        // Assert the variables are correctly set ---
        foreach ($expects as $key => $value)
        {
            $this->assertEquals($value, $_ENV[$key]);
        }

        $actual = isset($_ENV['NO_EQUAL_SIGN_HERE']);

        $this->assertFalse($actual);
        // ------------------------------------------
    }

    /**
     * @return void
     */
    public function test_passed_if_not_overwriting()
    {
        // Set a pre-existing variable ---
        $expect = 'PreExistingValue';

        $_ENV['TEST_NORMAL'] = $expect;
        // -------------------------------

        // Load the environment variables ---
        $path = __DIR__ . '/Fixture/Dotenv';

        Dotenv::load($path, '.env.example');
        // ----------------------------------

        // Assert the variable was not overwritten ---
        $actual = $_ENV['TEST_NORMAL'];

        $this->assertEquals($expect, $actual);
        // -------------------------------------------

        // Clean up the global state ---
        unset($_ENV['TEST_NORMAL']);
        // -----------------------------
    }
}
