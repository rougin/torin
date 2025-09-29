<?php

namespace Rougin\Torin\Fixture\Fakes;

use Staticka\Helper\LinkHelper;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class FakeLinkHelper extends LinkHelper
{
    public function __construct()
    {
        // Override constructor to avoid calling parent's constructor
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function set($name)
    {
        return (string) $name; // Return the name as a string, or any dummy string
    }
}
