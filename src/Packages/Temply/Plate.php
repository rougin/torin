<?php

namespace Rougin\Temply;

use Rougin\Slytherin\Template\RendererInterface;
use Rougin\Temply\Helpers\FormHelper;
use Staticka\Filter\LayoutFilter;
use Staticka\Helper\BlockHelper;
use Staticka\Helper\LayoutHelper;
use Staticka\Helper\LinkHelper;
use Staticka\Helper\PlateHelper;

/**
 * TODO: This should be from Staticka package.
 *
 * @package Temply
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Plate
{
    /**
     * @var \Staticka\Filter\FilterInterface[]
     */
    protected $filters = array();

    /**
     * @var \Staticka\Helper\HelperInterface[]
     */
    protected $helpers = array();

    /**
     * @var \Staticka\Helper\LinkHelper
     */
    protected $link;

    /**
     * @var \Rougin\Slytherin\Template\RendererInterface
     */
    protected $parent;

    /**
     * @param \Rougin\Slytherin\Template\RendererInterface $parent
     */
    public function __construct(RendererInterface $parent)
    {
        $render = new Render($parent);

        $this->parent = $parent;

        // Staticka Filters ----------------
        $this->filters[] = new LayoutFilter;
        // ---------------------------------

        // Staticka Helpers ------------------------------
        $this->helpers[] = new BlockHelper;

        $this->helpers[] = new LayoutHelper($render);

        $this->helpers[] = new PlateHelper($render);

        $this->helpers[] = (new FormHelper)->withAlpine();
        // -----------------------------------------------

        // TODO: Remove usage of "APP_URL" ---
        /** @var string */
        $link = getenv('APP_URL');

        $link = new LinkHelper($link);

        $this->link = $link;

        $this->helpers[] = $link;
        // -----------------------------------
    }

    /**
     * @return \Staticka\Helper\LinkHelper
     */
    public function getLinkHelper()
    {
        return $this->link;
    }

    /**
     * @param string               $name
     * @param array<string, mixed> $data
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function render($name, $data = array())
    {
        foreach ($this->helpers as $helper)
        {
            $data[$helper->name()] = $helper;
        }

        $html = $this->parent->render($name, $data);

        foreach ($this->filters as $filter)
        {
            $html = $filter->filter($html);
        }

        return (string) $html;
    }
}
