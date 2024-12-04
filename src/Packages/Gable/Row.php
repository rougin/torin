<?php

namespace Rougin\Gable;

/**
 * @package Gable
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Row extends Data
{
    /**
     * @param string|null  $class
     * @param string|null  $style
     * @param integer|null $width
     */
    public function __construct($class = null, $style = null, $width = null)
    {
        $this->class = $class;

        $this->style = $style;

        $this->width = $width;
    }
}
