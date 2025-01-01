<?php

namespace Rougin\Dexter\Alpine;

/**
 * TODO: This is a specific code for "tom-select".
 *
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Select
{
    /**
     * @var string
     */
    protected $id = '';

    /**
     * @var string|null
     */
    protected $link = null;

    /**
     * @param string $id
     * @param string|null $link
     */
    public function __construct($id, $link = null)
    {
        $this->id = $id;

        $this->link = $link;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $html = 'new TomSelect(\'' . $this->id . '\');';

        if ($this->link === null)
        {
            return $html;
        }

        $html = 'axios.get(\'' . $this->link . '\')';
        $html .= '.then(response =>';
        $html .= '{';
        $html .= 'let config = { options: response.data };';
        $html .= 'config.create = false;';
        $html .= 'config.plugins = [ \'dropdown_input\' ];';
        $html .= 'config.labelField = \'label\';';
        $html .= 'config.searchField = \'label\';';
        $html .= 'config.sortField = \'label\';';
        $html .= 'config.valueField = \'value\';';
        $html .= 'setTimeout(function ()';
        $html .= '{';
        $html .= 'new TomSelect(\'' . $this->id . '\', config);';
        $html .= '}, 1000);';
        $html .= '});';

        return $html;
    }
}
