<?php

namespace Rougin\Torin\Fixture\Fakes;

use Rougin\Torin\Depots\ItemDepot;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class FakeItemDepot extends ItemDepot
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
