<?php

namespace Rougin\Gable;

/**
 * @package Gable
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Table extends Element
{
    const TYPE_COL = 0;

    const TYPE_ROW = 1;

    /**
     * @var string
     */
    protected $actionName = '';

    /**
     * @var string|null
     */
    protected $alpineName = null;

    /**
     * @var \Rougin\Gable\Row[]
     */
    protected $cols = array();

    /**
     * @var boolean
     */
    protected $hasAction = false;

    /**
     * @var integer
     */
    protected $loadingCount = 0;

    /**
     * @var string|null
     */
    protected $loadingName = null;

    /**
     * @var string
     */
    protected $noItemsKey = 'empty';

    /**
     * @var string
     */
    protected $noItemsText = 'No items found.';

    /**
     * @var string
     */
    protected $loadErrorKey = 'loadError';

    /**
     * @var string
     */
    protected $loadErrorText = 'An error occured in getting the items.';

    /**
     * @var \Rougin\Gable\Row[]
     */
    protected $rows = array();

    /**
     * @var integer|null
     */
    protected $type = null;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->make();
    }

    /**
     * @param \Rougin\Gable\Cell $cell
     *
     * @return self
     */
    public function addCell(Cell $cell)
    {
        if ($this->type === self::TYPE_COL)
        {
            $index = count($this->cols) - 1;

            $this->cols[$index]->addCell($cell);
        }
        else
        {
            $index = count($this->rows) - 1;

            $this->rows[$index]->addCell($cell);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function make()
    {
        $html = '<table ' . $this->getParsedAttrs() . '>';

        if (count($this->cols) > 0)
        {
            $html .= '<thead>';

            foreach ($this->cols as $col)
            {
                $html .= $col->toHtml('th');
            }

            $html .= '</thead>';
        }

        if (count($this->rows) > 0)
        {
            $html .= '<tbody>';

            if ($this->alpineName && $this->loadingName)
            {
                $cells = count($this->cols[0]->getCells());

                $html .= '<template x-if="items.length === 0 && ' . $this->loadingName . '">';
                $html .= '<template x-data="{ length: items && items.length ? items.length : ' . $this->loadingCount . ' }" x-for="i in length">';
                $html .= '<tr>';

                foreach (range(1, $cells) as $item)
                {
                    $html .= '<td class="align-middle placeholder-glow">';
                    $html .= '<span class="placeholder col-12"></span>';
                    $html .= '</td>';
                }

                $html .= '</tr>';
                $html .= '</template>';
                $html .= '</template>';

                // Show "no items found" text if loading is enabled -------------------------
                $html .= '<template x-if="items.length === 0 && ' . $this->noItemsKey . '">';
                $html .= '<tr>';
                $html .= '<td colspan="' . $cells . '" class="align-middle text-center">';
                $html .= '<span>' . $this->noItemsText . '</span>';
                $html .= '</td>';
                $html .= '</tr>';
                $html .= '</template>';
                // --------------------------------------------------------------------------

                // Show "loading error" text if there is an error when loading --------------------------
                $html .= '<template x-if="! ' . $this->loadingName . ' && ' . $this->loadErrorKey . '">';
                $html .= '<tr>';
                $html .= '<td colspan="' . $cells . '" class="align-middle text-center">';
                $html .= '<span>' . $this->loadErrorText . '</span>';
                $html .= '</td>';
                $html .= '</tr>';
                $html .= '</template>';
                // --------------------------------------------------------------------------------------
            }

            if ($this->alpineName)
            {
                $html .= '<template x-if="items && items.length > 0">';
                $html .= '<template x-for="item in ' . $this->alpineName . '">';
            }

            foreach ($this->rows as $row)
            {
                $html .= $row->toHtml();
            }

            if ($this->alpineName)
            {
                $html .= '</template>';
                $html .= '</template>';
            }

            $html .= '</tbody>';
        }

        $html .= '</table>';

        return str_replace('<table >', '<table>', $html);
    }

    /**
     * @param string|null  $class
     * @param string|null  $style
     * @param integer|null $width
     *
     * @return self
     */
    public function newColumn($class = null, $style = null, $width = null)
    {
        $this->type = self::TYPE_COL;

        $this->cols[] = new Row($class, $style, $width);

        return $this;
    }

    /**
     * @param string|null  $class
     * @param string|null  $style
     * @param integer|null $width
     *
     * @return self
     */
    public function newRow($class = null, $style = null, $width = null)
    {
        $this->type = self::TYPE_ROW;

        $this->rows[] = new Row($class, $style, $width);

        return $this;
    }

    /**
     * @return self
     */
    public function reset()
    {
        $this->cols = array();

        $this->type = null;

        $this->rows = array();

        return $this;
    }

    /**
     * @param mixed|null   $value
     * @param string|null  $align
     * @param string|null  $class
     * @param integer|null $cspan
     * @param integer|null $rspan
     * @param string|null  $style
     * @param integer|null $width
     *
     * @return self
     */
    public function setCell($value, $align = null, $class = null, $cspan = null, $rspan = null, $style = null, $width = null)
    {
        return $this->addCell(new Cell($value, $align, $class, $cspan, $rspan, $style, $width));
    }

    /**
     * @param string|null  $align
     * @param string|null  $class
     * @param integer|null $cspan
     * @param integer|null $rspan
     * @param string|null  $style
     * @param integer|null $width
     *
     * @return self
     */
    public function setEmptyCell($align = null, $class = null, $cspan = null, $rspan = null, $style = null, $width = null)
    {
        return $this->setCell(null, $align, $class, $cspan, $rspan, $style, $width);
    }

    /**
     * @param array<string, mixed>[] $data
     *
     * @return self
     */
    public function setData($data = array())
    {
        $col = $this->cols[count($this->cols) - 1];

        foreach ($data as $item)
        {
            $this->newRow();

            foreach ($col->getCells() as $cell)
            {
                if (array_key_exists($cell->getName(), $item))
                {
                    $this->setCell($item[$cell->getName()]);
                }
                else
                {
                    $this->setEmptyCell();
                }
            }
        }

        return $this;
    }

    /**
     * @param mixed|null   $value
     * @param string|null  $align
     * @param string|null  $class
     * @param integer|null $cspan
     * @param integer|null $rspan
     * @param string|null  $style
     * @param integer|null $width
     *
     * @return self
     */
    public function withActions($value = 'Action', $align = null, $class = null, $cspan = null, $rspan = null, $style = null, $width = null)
    {
        $this->actionName = $value;

        $this->setCell($value, $align, $class, $cspan, $rspan, $style, $width);

        $this->hasAction = true;

        return $this;
    }


    /**
     * TODO: This is a specific code for "alpinejs".
     *
     * @param string       $name
     * @param string|null  $class
     * @param string|null  $style
     * @param integer|null $width
     *
     * @return self
     */
    public function withAlpine($name = 'items', $class = null, $style = null, $width = null)
    {
        $this->alpineName = $name;

        $col = $this->cols[count($this->cols) - 1];

        $this->newRow($class, $style, $width);

        foreach ($col->getCells() as $cell)
        {
            $new = new Cell(null, null, $class, $style, $width);

            $new->withAttr('x-text', 'item.' . $cell->getName());

            $this->addCell($new);
        }

        return $this;
    }

    /**
     * @param  string $text
     * @param string $key
     * @return self
     */
    public function withLoadErrorText($text, $key = 'loadError')
    {
        $this->loadErrorKey = $key;

        $this->loadErrorText = $text;

        return $this;
    }

    /**
     * TODO: This is a specific code for "alpinejs".
     *
     * @param  integer $count
     * @param  string  $name
     * @return self
     */
    public function withLoading($count = 5, $name = 'loading')
    {
        $this->loadingCount = $count;

        $this->loadingName = $name;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function withName($name)
    {
        if ($this->type === self::TYPE_COL)
        {
            $index = count($this->cols) - 1;

            $cell = $this->cols[$index]->getLast();

            $cell->setName($name);

            $this->cols[$index]->setLast($cell);

            return $this;
        }

        $index = count($this->rows) - 1;

        $cell = $this->rows[$index]->getLast();

        $cell->setName($name);

        $this->rows[$index]->setLast($cell);

        return $this;
    }

    /**
     * @param  string $text
     * @param string $key
     * @return self
     */
    public function withNoItemsText($text, $key = 'empty')
    {
        $this->noItemsKey = $key;

        $this->noItemsText = $text;

        return $this;
    }

    /**
     * Sets the width of the last cell in percentage.
     *
     * @param integer $width
     *
     * @return self
     */
    public function withWidth($width)
    {
        if ($this->type === self::TYPE_COL)
        {
            $index = count($this->cols) - 1;

            $cell = $this->cols[$index]->getLast();

            $cell->setWidth($width);

            $this->cols[$index]->setLast($cell);

            return $this;
        }

        $index = count($this->rows) - 1;

        $cell = $this->rows[$index]->getLast();

        $cell->setWidth($width);

        $this->rows[$index]->setLast($cell);

        return $this;
    }
}
