<?php

namespace Rougin\Temply;

/**
 * @package Temply
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Input extends Element
{
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->withType('text');

        $this->withName($name);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '<input ' . $this->getAttrs() . '>';
    }

    /**
     * @return self
     */
    public function asEmail()
    {
        return $this->withType('email');
    }

    /**
     * @return self
     */
    public function asNumber()
    {
        return $this->withType('number');
    }

    /**
     * TODO: This is a specific code for "alpinejs".
     *
     * @param string|null $name
     *
     * @return self
     */
    public function asModel($name = null)
    {
        return $this->with('x-model', $name ? $name : $this->attrs['name']);
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function withName($name)
    {
        return $this->with('name', $name);
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
