<?php

namespace Rougin\Torin\Routes;

use Rougin\Slytherin\Template\RendererInterface;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Hello
{
    /**
     * Returns the "Hello, Muggle!" text.
     *
     * @return string
     */
    public function index(RendererInterface $renderer)
    {
        return $renderer->render('index');
    }
}
