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
        // -----------------------------------------

        ob_start();

        // Set the "$_SERVER" variables manually ---
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['SERVER_PORT'] = '80';
        // -----------------------------------------

        // Run the application from "index.php" -----
        require __DIR__ . '/../app/public/index.php';
        // ------------------------------------------

        /** @var string */
        $actual = ob_get_contents();

        ob_end_clean();

        $actual = $this->parseHtml($actual);

        $this->assertEquals($expect, $actual);
    }
}
