<?php

namespace Rougin\Temply;

use Rougin\Slytherin\Template\RendererInterface;
use Staticka\Render\RenderInterface;

/**
 * TODO: Use RendererInterface instead from Staticka.
 *
 * @package Temply
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Render implements RenderInterface
{
    /**
     * @var \Rougin\Slytherin\Template\RendererInterface
     */
    protected $parent;

    /**
     * @param \Rougin\Slytherin\Template\RendererInterface $parent
     */
    public function __construct(RendererInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Renders a file from a specified template.
     *
     * @param string               $name
     * @param array<string, mixed> $data
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function render($name, $data = array())
    {
        return $this->parent->render($name, $data);
    }
}
