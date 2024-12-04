<?php

namespace Rougin\Gable;

/**
 * @package Gable
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Cell extends Element
{
    /**
     * @var string|null
     */
    protected $align = null;

    /**
     * @var integer|null
     */
    protected $cspan = null;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var integer|null
     */
    protected $rspan = null;

    /**
     * @var mixed|null
     */
    protected $value = null;

    /**
     * @param mixed|null   $value
     * @param string|null  $align
     * @param string|null  $class
     * @param integer|null $cspan
     * @param integer|null $rspan
     * @param string|null  $style
     * @param integer|null $width
     */
    public function __construct($value = null, $align = null, $class = null, $cspan = null, $rspan = null, $style = null, $width = null)
    {
        $this->align = $align;

        $this->class = $class;

        $this->cspan = $cspan;

        $this->rspan = $rspan;

        $this->style = $style;

        $this->width = $width;

        $this->value = $value;

        if ($value)
        {
            /** @var string $value */
            $this->name = ltrim(strtolower((string) preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $value)), '_');
        }
    }

    /**
     * @return string|null
     */
    public function getAlign()
    {
        return $this->align;
    }

    /**
     * @return integer|null
     */
    public function getColspan()
    {
        return $this->cspan;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return integer|null
     */
    public function getRowspan()
    {
        return $this->rspan;
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
