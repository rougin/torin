<?php

namespace Rougin\Temply;

/**
 * TODO: This is a specific code for "alpinejs".
 *
 * @package Temply
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Error
{
    /**
     * @var string
     */
    protected $field;

    /**
     * @var boolean
     */
    protected $first;

    /**
     * @param string  $field
     * @param boolean $first
     */
    public function __construct($field, $first = false)
    {
        $this->field = $field;

        $this->first = $first;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $html = '';

        $html .= '<template x-if="' . $this->field . '">';

        if ($this->first)
        {
            $html .= '<p class="text-danger small mb-0" x-text="' . $this->field . '"></p>';
        }
        else
        {
            $html .= '<p class="text-danger small mb-0" x-text="' . $this->field . '[0]"></p>';
        }

        $html .= '</template>';

        return $html;
    }
}
