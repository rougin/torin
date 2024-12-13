<?php

namespace Rougin\Gable;

/**
 * @package Gable
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Badge
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var string
     */
    protected $condition;

    /**
     * @var string
     */
    protected $text;

    /**
     * @param string $text
     * @param string $condition
     * @param string $class
     */
    public function __construct($text, $condition, $class)
    {
        $this->class = $class;

        $this->condition = $condition;

        $this->text = $text;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $item = '<template x-if="' . $this->condition . '">';

        $item .= '<span class="badge rounded-pill text-uppercase ' . $this->class . '">' . $this->text . '</span>';

        return $item . '</template>';
    }
}
