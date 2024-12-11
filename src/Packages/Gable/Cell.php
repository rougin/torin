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
     * @var string
     */
    protected $name = '';

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
        $this->withAttr('align', $align);

        if ($class)
        {
            $this->setClass($class);
        }

        $this->withAttr('cspan', $cspan);

        $this->withAttr('rspan', $rspan);

        if ($style)
        {
            $this->setStyle($style);
        }

        if ($width)
        {
            $this->setWidth($width);
        }

        $this->value = $value;

        if ($value)
        {
            $regex = '/[A-Z]([A-Z](?![a-z]))*/';

            /** @var string */
            $parsed = $value;

            /** @var string */
            $text = preg_replace($regex, '_$0', $parsed);

            $this->name = ltrim(strtolower($text), '_');
        }
    }

    /**
     * @return string|null
     */
    public function getAlign()
    {
        /** @var string|null */
        return $this->attrs['align'];
    }

    /**
     * @return integer|null
     */
    public function getColspan()
    {
        /** @var integer|null */
        return $this->attrs['cspan'];
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
        /** @var integer|null */
        return $this->attrs['rspan'];
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

    /**
     * @param mixed $value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
