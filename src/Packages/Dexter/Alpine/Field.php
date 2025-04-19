<?php

namespace Rougin\Dexter\Alpine;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Field
{
    /**
     * @var boolean
     */
    protected $array = false;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var boolean
     */
    protected $item = true;

    /**
     * @param string  $name
     * @param boolean $item
     */
    public function __construct($name, $item = true)
    {
        $this->name = $name;

        $this->item = $item;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return self
     */
    public function asArray()
    {
        $this->array = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getItem()
    {
        if ($this->item)
        {
            return 'item.' . $this->name;
        }

        return $this->name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSelf()
    {
        return 'self.' . $this->name;
    }

    /**
     * @return boolean
     */
    public function isArray()
    {
        return $this->array;
    }

    /**
     * @return boolean
     */
    public function isItem()
    {
        return $this->item;
    }
}
