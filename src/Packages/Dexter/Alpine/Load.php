<?php

namespace Rougin\Dexter\Alpine;

use Rougin\Gable\Pagee;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Load extends Method
{
    /**
     * @var string
     */
    protected $name = 'load';

    /**
     * @var \Rougin\Gable\Pagee
     */
    protected $pagee;

    /**
     * @param \Rougin\Gable\Pagee $pagee
     * @param string              $parent
     */
    public function __construct(Pagee $pagee, $parent)
    {
        $this->pagee = $pagee;

        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        $fn = 'function (page)';
        $fn .= '{';
        $fn .= 'const self = this;';
        $fn .= 'self.loading = true;';
        $fn .= 'let data = { ' . $this->pagee->getPageKey() . ': page };';
        $fn .= 'self.pagee.page = page;';
        $fn .= 'data.' . $this->pagee->getLimitKey() . ' = ' . $this->pagee->getLimit() . ';';
        $fn .= 'const search = new URLSearchParams(data);';
        $fn .= 'axios.get(link + \'?\' + search.toString())';
        $fn .= '.then(function (response)';
        $fn .= '{';
        $fn .= 'const result = response.data;';
        $fn .= 'if (result.items.length === 0)';
        $fn .= '{';
        $fn .= 'self.empty = true;';
        $fn .= '}';
        $fn .= 'self.pagee.limit = result.limit;';
        $fn .= 'self.pagee.pages = result.pages;';
        $fn .= 'self.pagee.total = result.total;';
        $fn .= 'self.items = result.items;';
        $fn .= '})';
        $fn .= '.catch(function (error)';
        $fn .= '{';
        $fn .= 'self.loadError = true;';
        $fn .= '})';
        $fn .= '.finally(function ()';
        $fn .= '{';
        $fn .= 'self.loading = false;';
        $fn .= '})';
        $fn .= '}';

        return $fn;
    }
}
