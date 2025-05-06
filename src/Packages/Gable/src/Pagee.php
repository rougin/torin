<?php

namespace Rougin\Gable;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @package Gable
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Pagee
{
    const BTN_DISABLED = 0;

    const BTN_ACTIVE = 1;

    /**
     * @var boolean
     */
    protected $alpine = false;

    /**
     * @var integer
     */
    protected $limit = 10;

    /**
     * @var string
     */
    protected $limitKey = 'l';

    /**
     * @var string|null
     */
    protected $link = null;

    /**
     * @var integer
     */
    protected $page = 1;

    /**
     * @var string
     */
    protected $pageKey = 'p';

    /**
     * @var integer
     */
    protected $total = 0;

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param string                                   $limit
     * @param string                                   $page
     *
     * @return self
     */
    public static function fromRequest(ServerRequestInterface $request, $limit = 'l', $page = 'p')
    {
        $self = new Pagee;

        $self->setLimitKey($limit);

        $self->setPageKey($page);

        /** @var array<string, string> */
        $params = $request->getQueryParams();

        $key = $self->getLimitKey();

        if (array_key_exists($key, $params))
        {
            $limit = $params[$key];

            $self->setLimit((int) $limit);
        }

        $key = $self->getPageKey();

        if (array_key_exists($key, $params))
        {
            $page = $params[$key];

            $self->setPage((int) $page);
        }

        return $self;
    }

    /**
     * @param integer     $page
     * @param integer     $limit
     * @param string|null $link
     */
    public function __construct($page = 1, $limit = 10, $link = null)
    {
        $this->limit = (int) $limit;

        $this->link = $link;

        $this->page = (int) $page;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $html = '<div class="d-inline-block">';
        $html .= '<ul class="pagination">';

        if (! $this->alpine)
        {
            // "First page" button ------------------------------
            $disabled = $this->page === 1;
            $link = $this->setUrl(1);
            $html .= $this->setButton('First', $link, $disabled);
            // --------------------------------------------------

            // "Previous" button -----------------------------------
            $disabled = $this->page <= 1;
            $link = $this->setUrl($this->page - 1, $disabled);
            $html .= $this->setButton('Previous', $link, $disabled);
            // -----------------------------------------------------

            $total = (int) ceil($this->total / $this->limit);

            foreach (range(1, $total) as $page)
            {
                $active = $page === $this->page;

                $link = $this->setUrl($page, $active);

                $text = (string) $page;

                $html .= $this->setButton($text, $link, $active, self::BTN_ACTIVE);
            }

            // "Next" button -----------------------------------
            $disabled = $this->page >= $total;
            $link = $this->setUrl($this->page + 1, $disabled);

            $html .= $this->setButton('Next', $link, $disabled);
            // -------------------------------------------------

            // "Last page" button ------------------------------
            $disabled = $this->page === $total;
            $link = $this->setUrl($total);
            $html .= $this->setButton('Last', $link, $disabled);
            // -------------------------------------------------

            $html .= '</ul>';
            $html .= '</div>';

            return $html;
        }

        $html .= '<li class="page-item" :class="{ \'disabled\': pagee.page === 1 }">';
        $html .= '<a class="page-link" :href="pagee.url(1)" :page="1" @click.prevent="pagee.view($dispatch, $el)">First</a>';
        $html .= '</li>';
        $html .= '<li class="page-item" :class="{ \'disabled\': pagee.page <= 1 }">';
        $html .= '<a class="page-link" :href="pagee.url(pagee.page - 1)" :page="pagee.page - 1" @click.prevent="pagee.view($dispatch, $el)">Prev</a>';
        $html .= '</li>';
        $html .= '<template x-for="(page, index) in pagee.items()" :key="index">';
        $html .= '<li class="page-item" :class="{ \'active\': (index + 1) === pagee.page }">';
        $html .= '<a class="page-link" :href="pagee.url(index + 1)" :page="index + 1" @click.prevent="pagee.view($dispatch, $el)" x-text="index + 1"></a>';
        $html .= '</li>';
        $html .= '</template>';
        $html .= '<li class="page-item" :class="{ \'disabled\': pagee.page >= pagee.pages }">';
        $html .= '<a class="page-link" :href="pagee.url(pagee.page + 1)" :page="pagee.page + 1" @click.prevent="pagee.view($dispatch, $el)">Next</a>';
        $html .= '</li>';
        $html .= '<li class="page-item" :class="{ \'disabled\': pagee.page === pagee.pages }">';
        $html .= '<a class="page-link" :href="pagee.url(pagee.pages)" :page="pagee.pages" @click.prevent="pagee.view($dispatch, $el)">Last</a>';
        $html .= '</li>';

        $html .= '</ul>';
        $html .= '</div>';

        return $html;
    }

    /**
     * @return self
     */
    public function asAlpine()
    {
        $this->alpine = true;

        return $this;
    }

    /**
     * @return integer
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return string
     */
    public function getLimitKey()
    {
        return $this->limitKey;
    }

    /**
     * @return string|null
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return integer
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return string
     */
    public function getPageKey()
    {
        return $this->pageKey;
    }

    /**
     * @return integer
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param integer $limit
     *
     * @return self
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param string $limitKey
     *
     * @return self
     */
    public function setLimitKey($limitKey)
    {
        $this->limitKey = $limitKey;

        return $this;
    }

    /**
     * @param string $link
     *
     * @return self
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @param integer $page
     *
     * @return self
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param string $pageKey
     *
     * @return self
     */
    public function setPageKey($pageKey)
    {
        $this->pageKey = $pageKey;

        return $this;
    }

    /**
     * @param integer $total
     *
     * @return self
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @param string $dispatchKey
     *
     * @return string
     */
    public function toObject($dispatchKey)
    {
        $object = '{limit:[LIMIT],limitKey:"[LIMIT_KEY]",link:"[LINK]",dispatchKey:"[DISPATCH_KEY]",page:"[PAGE]",pageKey:"[PAGE_KEY]",pages:0,total:[TOTAL],items:function(){if(0===this.pages){const t=this.total/this.limit;this.pages=Math.ceil(t)}return Array.from({length:this.pages})},url:function(t){return this.link+"?"+this.pageKey+"="+t+"&"+this.limitKey+"="+this.limit},view:function(t,i){const e=parseInt(i.getAttribute("page"));e!==this.page&&(history.pushState({},"",i.href),t(this.dispatchKey,e))}}';

        $object = str_replace('[DISPATCH_KEY]', $dispatchKey, $object);

        $object = str_replace('[LIMIT]', (string) $this->getLimit(), $object);

        $object = str_replace('[LIMIT_KEY]', $this->getLimitKey(), $object);

        $object = str_replace('[LINK]', (string) $this->getLink(), $object);

        $object = str_replace('[PAGE]', (string) $this->getPage(), $object);

        $object = str_replace('[PAGE_KEY]', $this->getPageKey(), $object);

        $object = str_replace('[TOTAL]', (string) $this->getTotal(), $object);

        return $dispatchKey . '.pagee=' . $object;
    }

    /**
     * @param string  $name
     * @param string  $link
     * @param boolean $status
     * @param integer $type
     *
     * @return string
     */
    protected function setButton($name, $link, $status = false, $type = self::BTN_DISABLED)
    {
        $active = $status ? ' active' : '';
        $disabled = $status ? ' disabled' : '';

        $class = $type === self::BTN_DISABLED ? $disabled : $active;

        $html = '<li class="page-item' . $class . '">';
        $html .= '<a class="page-link" href="' . $link . '">';
        $html .= '<span>' . $name . '</span>';
        $html .= '</a>';
        $html .= '</li>';

        return $html;
    }

    /**
     * @param integer $page
     * @param boolean $active
     *
     * @return string
     */
    protected function setUrl($page, $active = false)
    {
        $link = $this->link . '?' . $this->pageKey . '=' . $page;

        $link .= '&' . $this->limitKey . '=' . $this->limit;

        return $active ? 'javascript:void(0)' : $link;
    }
}
