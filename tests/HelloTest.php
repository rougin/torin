<?php

namespace Rougin\Torin;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class HelloTest extends Testcase
{
    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function test_should_run_front_controller()
    {
        // Expect the template from "Hello" page ---
        $expect = $this->getPlate('Hello');

        $this->expectOutputString($expect);
        // -----------------------------------------

        // Set the "$_SERVER" variables manually ---
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['SERVER_PORT'] = '80';
        // -----------------------------------------

        // Run the application from "index.php" -----
        require __DIR__ . '/../app/public/index.php';
        // ------------------------------------------
    }
}
