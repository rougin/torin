<?php

namespace Rougin\Temply;

/**
 * @package Temply
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Label extends Element
{
    /**
     * @var boolean
     */
    protected $required = false;

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
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $attrs = $this->getAttrs();

        $text = $this->text;

        if ($this->required)
        {
            $text .= ' <span class="text-danger">*</span>';
        }

        return '<label ' . $attrs . '>' . $text . '</label>';
    }

    /**
     * @return self
     */
    public function asRequired()
    {
        $this->required = true;

        return $this;
    }

    /**
     * @param string $name
     * @return self
     */
    public function for($name)
    {
        return $this->with('for', $name);
    }

    /**
     * @param  string $type
     * @return self
     */
    public function withType($type)
    {
        return $this->with('type', $type);
    }
}
