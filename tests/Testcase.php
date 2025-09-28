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

    public function setUp(): void
    {
        parent::setUp();

        $this->capsule = new Capsule;
        $this->capsule->addConnection([
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ], 'torin'); // Named 'torin' to be picked up by Eloquent

        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }

    public function tearDown(): void
    {
        $this->capsule->getConnection('torin')->disconnect();
        parent::tearDown();
    }
}
