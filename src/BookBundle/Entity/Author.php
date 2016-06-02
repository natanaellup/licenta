<?php

namespace BookBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use UserBundle\Entity\User;

class Author
{
    const NAME_PATH = 'author_image';

    const IMAGE_DIR = 'uploads/author_image';

    /**
     * Author id.
     *
     * @var integer
     */
    private $id;

    /**
     * Author first name.
     *
     * @var string
     */
    private $firstName;

    /**
     * Author last name.
     *
     * @var string
     */
    private $lastName;

    /**
     * Author description.
     *
     * @var string
     */
    private $description;

    /**
     * Image url.
     *
     * @var string
     */
    private $imageUrl;

    /**
     * Image file.
     *
     * @var UploadedFile
     */
    private $image;

    /**
     * Old image url.
     *
     * @var string
     */
    private $oldImageUrl;

    /**
     * Active author?
     *
     * @var boolean
     */
    private $active;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Book[]
     */
    private $books;

    /**
     * Author constructor.
     */
    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Author
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Author
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->firstName.' '.$this->lastName;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Author
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param UploadedFile|null $image
     * @return $this
     */
    public function setImage(UploadedFile $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getOldImageUrl()
    {
        return $this->oldImageUrl;
    }

    /**
     * @param string $imageUrl
     * @return $this
     */
    public function setImageUrl($imageUrl)
    {
        $this->oldImageUrl = $this->imageUrl;
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return (boolean) $this->active;
    }

    /**
     * @param bool $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;
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
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Book[]|ArrayCollection
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @param Book $book
     * @param $updateRelation
     * @return $this
     */
    public function addBook(Book $book, $updateRelation)
    {
        $this->books[] = $book;
        if($updateRelation){
            $book->addAuthor($this,false);
        }

        return $this;
    }

    /**
     * @param Book $book
     * @param $updateRelation
     * @return $this
     */
    public function removeBook(Book $book, $updateRelation)
    {
        $this->books->removeElement($book);
        if($updateRelation){
            $book->removeAuthor($this,false);
        }

        return $this;
    }

    /**
     * @param ArrayCollection $books
     * @return ArrayCollection
     */
    public function setBooks(ArrayCollection $books)
    {
        $this->books = $books;
        return $books;
    }

    /**
     * Get active books.
     *
     * @return Book|mixed|null
     */
    public function getActiveBooks()
    {
        $activeBooks = new ArrayCollection();

        foreach($this->books as $book)
        {
            if($book->isActive()){
                $activeBooks->add($book);
            }
        }

        return $activeBooks;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if(!is_null($this->firstName) && !is_null($this->lastName)){
            return $this->firstName.' '.$this->lastName;
        }

        return '';
    }
}