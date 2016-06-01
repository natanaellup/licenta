<?php

namespace BookBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Category
{

    /**
     * Book category id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Category name.
     *
     * @var string
     */
    protected $name;

    /**
     * @var ArrayCollection
     */
    protected $subcategories;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->subcategories =  new ArrayCollection();
    }

    /**
     * Get book category id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get book category name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set book category name.
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param $subcategory
     * @return $this
     */
    public function addSubcategory($subcategory)
    {
        $this->subcategories->add($subcategory);

        return $this;
    }

    /**
     * @param $subcategory
     * @return $this
     */
    public function removeSubcategory($subcategory)
    {
        $this->subcategories->removeElement($subcategory);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSubcategories()
    {
        return $this->subcategories;
    }

    /**
     * @param $subcategories
     * @return $this
     */
    public function setSubcategories($subcategories)
    {
        $this->subcategories = $subcategories;

        return $this;
    }

    /**
     * Implement to string function.
     *
     * @return string
     */
    public function __toString()
    {
        if(!is_null($this->name)){
            return $this->name;
        }

        return '';
    }
}