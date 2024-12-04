<?php

namespace Rougin\Gable;

/**
 * @package Gable
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Element
{
    /**
     * @var string|null
     */
    protected $class = null;

    /**
     * @var string|null
     */
    protected $style = null;

    /**
     * @var integer|null
     */
    protected $width = null;

    /**
     * @return string|null
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return string|null
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @return integer|null
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param string $class
     *
     * @return self
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @param string $style
     *
     * @return self
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Sets the width of the cell in percentage.
     *
     * @param integer $width
     *
     * @return self
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }
}
