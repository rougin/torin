<?php

namespace Rougin\Dexter\Alpine;

use Rougin\Gable\Pagee;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Depot
{
    /**
     * @var \Rougin\Dexter\Alpine\Method[]
     */
    protected $fns = array();

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \Rougin\Temply\Script|null
     */
    protected $script = null;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return \Rougin\Dexter\Alpine\Close
     */
    public function withClose()
    {
        return new Close($this->name);
    }

    /**
     * @return \Rougin\Dexter\Alpine\Edit
     */
    public function withEdit()
    {
        return new Edit($this->name);
    }

    /**
     * @param integer $page
     *
     * @return \Rougin\Dexter\Alpine\Init
     */
    public function withInit($page = 1)
    {
        return new Init($page, $this->name);
    }

    /**
     * @param \Rougin\Gable\Pagee $pagee
     *
     * @return \Rougin\Dexter\Alpine\Load
     */
    public function withLoad(Pagee $pagee)
    {
        return new Load($pagee, $this->name);
    }

    /**
     * @param string $name
     *
     * @return \Rougin\Dexter\Alpine\Modal
     */
    public function withModal($name)
    {
        $modal = new Modal($this->name);

        /** @var \Rougin\Dexter\Alpine\Modal */
        return $modal->setName($name);
    }

    /**
     * @return \Rougin\Dexter\Alpine\Remove
     */
    public function withRemove()
    {
        return new Remove($this->name);
    }

    /**
     * @return \Rougin\Dexter\Alpine\Store
     */
    public function withStore()
    {
        return new Store($this->name);
    }

    /**
     * @return \Rougin\Dexter\Alpine\Trash
     */
    public function withTrash()
    {
        return new Trash($this->name);
    }

    /**
     * @return \Rougin\Dexter\Alpine\Update
     */
    public function withUpdate()
    {
        return new Update($this->name);
    }
}
