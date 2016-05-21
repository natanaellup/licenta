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
    private $id;

    /**
     * Category name.
     *
     * @var string
     */
    private $name;

    /**
     * @var ArrayCollection
     */
    private $books;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->books =  new ArrayCollection();
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
     * @param $book
     * @return $this
     */
    public function addBook($book)
    {
        $this->books->add($book);

        return $this;
    }

    /**
     * @param $book
     * @return $this
     */
    public function removeBook($book)
    {
        $this->books->removeElement($book);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @param $books
     * @return $this
     */
    public function setBooks($books)
    {
        $this->books = $books;

        return $this;
    }

    /**
     * Get number of active books.
     *
     * @return int
     */
    public function getNoActiveBooks()
    {
        $count = 0;

        foreach($this->books as $book){
            if($book->isActive()){
                $count++;
            }
        }

        return $count;
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