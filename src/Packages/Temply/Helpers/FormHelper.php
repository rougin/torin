<?php

namespace Rougin\Temply\Helpers;

use Staticka\Helper\HelperInterface;

/**
 * @package Temply
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class FormHelper implements HelperInterface
{
    public function buttonLink($text, $link, $class = null)
    {
        return '<a href="' . $link . '" class="' . $class . '">' . $text . '</a>';
    }

    /**
     * Returns the name of the helper.
     *
     * @return string
     */
    public function name()
    {
        return 'form';
    }
}
