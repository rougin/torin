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
    protected $id;

    /**
     * @var string|null
     */
    protected $link = null;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string      $name
     * @param string      $id
     * @param string|null $link
     */
    public function __construct($name, $id, $link = null)
    {
        $this->name = $name;

        $this->id = $id;

        $this->link = $link;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $html = 'new TomSelect(\'' . $this->id . '\', {';
        $html .= 'create: false,';
        $html .= 'plugins: [ \'dropdown_input\' ],';
        $html .= 'labelField: \'label\',';
        $html .= 'searchField: \'label\',';
        $html .= 'sortField: \'label\',';
        $html .= 'valueField: \'value\'';

        if ($this->link)
        {
            $html .= ',preload: true,';
            $html .= 'load: function(query, cb) {';
            $html .= '  const url = \'' . $this->link . '\';';
            $html .= '  fetch(url).then(response => response.json())';
            $html .= '    .then(json => cb(json))';
            $html .= '    .catch(() => { cb() });';
            $html .= '}';
        }

        return $html . '});';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
