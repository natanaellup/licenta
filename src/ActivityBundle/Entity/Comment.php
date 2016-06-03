<?php

namespace ActivityBundle\Entity;

use BookBundle\Entity\Book;
use UserBundle\Entity\User;

class Comment
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var Book
     */
    protected $book;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var \DateTime
     */
    protected $dateTime;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Book
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * @param Book $book
     * @return Comment
     */
    public function setBook($book)
    {
        $this->book = $book;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Comment
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    public function getDateTimeFormatted()
    {
        return $this->dateTime->format('Y-m-d');
    }

    /**
     * @param \DateTime $dateTime
     * @return Comment
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
        return $this;
    }

}