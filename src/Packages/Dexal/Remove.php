<?php

namespace Rougin\Dexal;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Remove extends Method
{
    /**
     * @var string
     */
    protected $name = 'remove';

    /**
     * @var string
     */
    protected $text = 'Item successfully deleted.';

    /**
     * @var string
     */
    protected $title = 'Item deleted!';

    /**
     * @return string
     */
    public function getHtml()
    {
        $fn = 'function (id)';
        $fn .= '{';
        $fn .= 'const input = new FormData;';
        $fn .= 'const self = this;';

        foreach ($this->fields as $field)
        {
            $fn .= $field->getSelf() . ' = ' . $field->getItem() . ';';
        }

        $fn .= 'self.loading = true;';
        $fn .= 'self.error = {};';
        $fn .= 'axios.delete(\'' . $this->link . '\' + \'/\' + id, input)';
        $fn .= '.then(function (response)';
        $fn .= '{';
        $fn .= 'self.close();';
        $fn .= 'Alert.success(\'' . $this->title . '\', \'' . $this->text . '\');';
        $fn .= 'self.load(self.pagee.page);';
        $fn .= '})';
        $fn .= '.catch(function (error)';
        $fn .= '{';
        $fn .= 'self.error = error.response.data;';
        $fn .= '})';
        $fn .= '.finally(function ()';
        $fn .= '{';
        $fn .= 'self.loading = false;';
        $fn .= '});';
        $fn .= '}';

        return $fn;
    }

    /**
     * @param string $title
     * @param string $text
     *
     * @return self
     */
    public function setAlert($title, $text)
    {
        $this->text = $text;

        $this->title = $title;

        return $this;
    }
}
