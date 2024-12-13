<?php

namespace Rougin\Temply;

/**
 * TODO: This is a specific code for "alpinejs".
 *
 * @package Temply
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Script
{
    /**
     * @var array<string, mixed>
     */
    protected $fields = array();

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        /** @var string */
        $data = json_encode($this->fields);

        return 'let ' . $this->name . ' = ' . $data . ';';
    }

    /**
     * @return array<string, mixed>
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param string     $field
     * @param mixed|null $default
     *
     * @return self
     */
    public function with($field, $default = null)
    {
        $this->fields[$field] = $default;

        return $this;
    }

    /**
     * @return self
     */
    public function withError()
    {
        return $this->with('error', (object) array());
    }

    /**
     * @param boolean $value
     *
     * @return self
     */
    public function withLoading($value = false)
    {
        return $this->with('loading', $value);
    }
}
