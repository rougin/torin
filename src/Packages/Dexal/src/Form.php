<?php

namespace Rougin\Dexal;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Form extends Method
{
    const TYPE_CREATE = 0;

    const TYPE_UPDATE = 1;

    /**
     * @var string
     */
    protected $text = 'Item successfully created.';

    /**
     * @var string
     */
    protected $title = 'Item created!';

    /**
     * @var integer
     */
    protected $type = self::TYPE_CREATE;

    /**
     * @return string
     */
    public function getHtml()
    {
        $fn = 'function ()';

        if ($this->type === self::TYPE_UPDATE)
        {
            $fn = 'function (id)';
        }

        $fn .= '{';
        $fn .= 'const input = new FormData;';
        $fn .= 'const self = this;';

        foreach ($this->fields as $field)
        {
            $name = $field->getName();

            if (! $field->isArray())
            {
                $fn .= 'input.append(\'' . $name . '\', ' . $field->getSelf() . ');';

                continue;
            }

            // Traverse each item object and append them to the FormData instance -------------------
            $fn .= $field->getSelf() . '.forEach(function (item, index)';
            $fn .= '{';
            $fn .= '  if (! (item instanceof Object))';
            $fn .= '  {';
            $fn .= '    input.append(\'' . $name . '[\' + index + \']\', item);';
            $fn .= '    return;';
            $fn .= '  }';

            $fn .= '  Object.keys(item).forEach(function (key)';
            $fn .= '  {';
            $fn .= '    input.append(\'' . $name . '[\' + index + \'][\' + key + \']\', item[key]);';
            $fn .= '  });';
            $fn .= '});';
            // --------------------------------------------------------------------------------------
        }

        $fn .= 'self.loading = true;';
        $fn .= 'self.error = {};';

        if ($this->type === self::TYPE_CREATE)
        {
            $fn .= 'axios.post(\'' . $this->link . '\', input)';
        }
        else
        {
            $fn .= 'axios.put(\'' . $this->link . '\' + \'/\' + id, input)';
        }

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
