<?php

namespace Rougin\Torin\Fixture\Fakes;

use Rougin\Torin\Depots\OrderDepot;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class FakeOrderDepot extends OrderDepot
{
    /**
     * @var integer
     */
    protected $total = 0;

    /**
     * @param integer $total
     */
    public function __construct($total = 0)
    {
        $this->total = $total;
    }

    /**
     * @return integer
     */
    public function getTotal()
    {
        return $this->total;
    }

    // Override other methods as needed for specific test cases
}
