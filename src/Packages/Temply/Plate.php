<?php

namespace Rougin\Temply;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Slytherin\Template\RendererInterface;
use Rougin\Temply\Helpers\FormHelper;
use Rougin\Temply\Helpers\LinkHelper;
use Staticka\Filter\LayoutFilter;
use Staticka\Helper\BlockHelper;
use Staticka\Helper\LayoutHelper;
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
     * @param \Psr\Http\Message\ServerRequestInterface     $request
     */
    public function __construct(RendererInterface $parent, ServerRequestInterface $request)
    {
        $render = new Render($parent);

        $this->parent = $parent;

        // Staticka Filters ----------------
        $this->filters[] = new LayoutFilter;
        // ---------------------------------

        // Staticka Helpers ------------------------------
        $this->helpers[] = (new FormHelper)->withAlpine();

        $this->helpers[] = new PlateHelper($render);

        $this->helpers[] = new BlockHelper;

        $this->helpers[] = new LayoutHelper($render);
        // -----------------------------------------------

        // TODO: Remove usage of "APP_URL" ----------
        $server = $request->getServerParams();

        /** @var string */
        $link = getenv('APP_URL');

        $this->link = new LinkHelper($link, $server);

        $this->helpers[] = $this->link;
        // ------------------------------------------
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
