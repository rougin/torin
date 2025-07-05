<?php

namespace Rougin\Dexal;

use Rougin\Gable\Pagee;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Depot
{
    /**
     * @var \Rougin\Dexal\Method[]
     */
    protected $fns = array();

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \Rougin\Fortem\Script|null
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
     * @return \Rougin\Dexal\Close
     */
    public function withClose()
    {
        return new Close($this->name);
    }

    /**
     * @return \Rougin\Dexal\Edit
     */
    public function withEdit()
    {
        return new Edit($this->name);
    }

    /**
     * @param integer $page
     *
     * @return \Rougin\Dexal\Init
     */
    public function withInit($page = 1)
    {
        return new Init($page, $this->name);
    }

    /**
     * @param \Rougin\Gable\Pagee $pagee
     *
     * @return \Rougin\Dexal\Load
     */
    public function withLoad(Pagee $pagee)
    {
        return new Load($pagee, $this->name);
    }

    /**
     * @param string $name
     *
     * @return \Rougin\Dexal\Modal
     */
    public function withModal($name)
    {
        $modal = new Modal($this->name);

        /** @var \Rougin\Dexal\Modal */
        return $modal->setName($name);
    }

    /**
     * @return \Rougin\Dexal\Remove
     */
    public function withRemove()
    {
        return new Remove($this->name);
    }

    /**
     * @return \Rougin\Dexal\Store
     */
    public function withStore()
    {
        return new Store($this->name);
    }

    /**
     * @return \Rougin\Dexal\Trash
     */
    public function withTrash()
    {
        return new Trash($this->name);
    }

    /**
     * @return \Rougin\Dexal\Update
     */
    public function withUpdate()
    {
        return new Update($this->name);
    }
}
