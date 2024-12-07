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
     * @var array<string, mixed>
     */
    protected $attrs = array();

    /**
     * @return array<string, mixed>
     */
    public function getAttrs()
    {
        return $this->attrs;
    }

    /**
     * @return string
     */
    public function getParsedAttrs()
    {
        $attrs = array();

        foreach ($this->getAttrs() as $key => $value)
        {
            if ($key === 'width' && $value !== null)
            {
                $value = $value . '%';
            }

            if ($value !== null)
            {
                $attrs[] = $key . '="' . $value . '"';
            }
        }

        return implode(' ', $attrs);
    }

    /**
     * @param string $class
     *
     * @return self
     */
    public function setClass($class)
    {
        return $this->withAttr('class', $class);
    }

    /**
     * @param string $style
     *
     * @return self
     */
    public function setStyle($style)
    {
        return $this->withAttr('style', $style);
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
        return $this->withAttr('width', $width);
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return self
     */
    public function withAttr($key, $value)
    {
        $this->attrs[$key] = $value;

        return $this;
    }
}
