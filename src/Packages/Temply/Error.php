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
     * @param string $field
     */
    public function __construct($field)
    {
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $html = '';

        $html .= '<template x-if="' . $this->field . '">';
        $html .= '<p class="text-danger small mb-0" x-text="' . $this->field . '[0]"></p>';
        $html .= '</template>';

        return $html;
    }
}
