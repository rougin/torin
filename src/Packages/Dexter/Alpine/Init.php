<?php

namespace Rougin\Dexter\Alpine;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Init extends Method
{
    /**
     * @var string
     */
    protected $name = 'init';

    /**
     * @var integer
     */
    protected $page = 0;

    /**
     * @param integer $page
     * @param string  $parent
     */
    public function __construct($page, $parent)
    {
        $this->page = $page;

        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        $fn = 'function ()';
        $fn .= '{';
        $fn .= 'this.load(' . $this->page . ');';
        $fn .= '}';

        return $fn;
    }
}
