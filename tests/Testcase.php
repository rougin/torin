<?php

namespace Rougin\Torin;

use LegacyPHPUnit\TestCase as Legacy;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * @codeCoverageIgnore
 *
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Testcase extends Legacy
{
    /**
     * @var \Illuminate\Database\Capsule\Manager
     */
    protected $capsule;

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->capsule = new Capsule;
        $this->capsule->addConnection([
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ], 'torin'); // Named 'torin' to be picked up by Eloquent

        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }

    /**
     * @return void
     */
    protected function doTearDown()
    {
        $this->capsule->getConnection('torin')->disconnect();
    }
}
