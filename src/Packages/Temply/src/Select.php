<?php

namespace Rougin\Temply;

/**
 * @package Temply
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Select extends Element
{
    /**
     * @var array<string, string>[]
     */
    protected $items = array();

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->withName($name);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $html = '<select ' . $this->getAttrs() . '>';

        $html .= '<option value="">Please select</option>';

        foreach ($this->items as $item)
        {
            $html .= '<option value="' . $item['id'] . '">' . $item['name'] . '</option>';
        }

        return $html . '</select>';
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
     * @param array<string, string>[] $items
     *
     * @return self
     */
    public function withItems($items)
    {
        $this->items = $items;

        return $this;
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
}
