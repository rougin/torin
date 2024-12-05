<?php

namespace Rougin\Temply;

/**
 * @package Temply
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Button extends Element
{
    /**
     * @var string
     */
    protected $text;

    /**
     * @param string $text
     */
    public function __construct($text)
    {
        $this->text = $text;

        $this->withType('button');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '<button ' . $this->getAttrs() . '>' . $this->text . '</button>';
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function onClick($name)
    {
        return $this->with('@click', $name);
    }

    /**
     * @param string $type
     *
     * @return self
     */
    public function withType($type)
    {
        return $this->with('type', $type);
    }
}
