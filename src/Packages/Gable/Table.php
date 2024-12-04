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
     * @var \Rougin\Gable\Row[]
     */
    protected $cols = array();

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
     * @return string
     */
    public function make()
    {
        $width = $this->getWidth() ? $this->getWidth() . '%' : null;

        $html = '<table class="' . $this->getClass() . '" style="' . $this->getStyle() . '" width="' . $width . '">';

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

            foreach ($this->rows as $row)
            {
                $html .= $row->toHtml();
            }

            $html .= '</tbody>';
        }

        $html .= '</table>';

        // Remove empty attributes -----------------
        $html = str_replace(' class=""', '', $html);
        $html = str_replace(' style=""', '', $html);
        $html = str_replace(' width=""', '', $html);
        // -----------------------------------------

        return (string) $html;
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
        $cell = new Cell($value, $align, $class, $cspan, $rspan, $style, $width);

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
