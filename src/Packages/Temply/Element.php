<?php

namespace Rougin\Temply;

/**
 * @package Temply
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
     * TODO: This is a specific code for "alpinejs".
     *
     * @param string $name
     *
     * @return static
     */
    public function disablesOn($name)
    {
        return $this->with(':disabled', $name);
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return static
     */
    public function with($key, $value)
    {
        $this->attrs[$key] = $value;

        return $this;
    }

    /**
     * @param string $class
     *
     * @return static
     */
    public function withClass($class)
    {
        return $this->with('class', $class);
    }

    /**
     * @return string
     */
    protected function getAttrs()
    {
        $items = array();

        foreach ($this->attrs as $key => $value)
        {
            $items[] = $key . '="' . $value . '"';
        }

        return implode(' ', $items);
    }
}
