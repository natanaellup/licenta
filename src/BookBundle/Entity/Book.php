<?php

namespace BookBundle\Entity;

use ActivityBundle\Entity\Comment;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use UserBundle\Entity\User;

class Book
{
    const NAME_PATH_IMAGE = 'book_image';

    const IMAGE_DIR_BOOK = 'uploads/book/image';

    const NAME_PATH_DOCUMENT = 'book_document';

    const DOCUMENT_DIR_BOOK = 'uploads/book/document';

    /**
     * Author id.
     *
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Author[]
     */
    private $authors;

    /**
     * @var Subcategory
     */
    private $subcategory;

    /**
     * @var UploadedFile
     */
    private $image;

    /**
     * @var string
     */
    private $imageUrl;

    /**
     * @var string
     */
    private $oldImageUrl;

    /**
     * @var UploadedFile
     */
    private $document;

    /**
     * @var string
     */
    private $documentUrl;

    /**
     * @var string
     */
    private $oldDocumentUrl;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var User
     */
    private $user;

    /**
     * @var \DateTime
     */
    private $addDate;

    /**
     * @var boolean
     */
    private $featured;

    /**
     * @var boolean
     */
    private $mainFeatured;

    /**
     * @var ArrayCollection
     */
    private $comments;

    /**
     * @var ArrayCollection
     */
    private $likes;

    /**
     * Book constructor.
     */
    public function __construct()
    {
        $this->authors = new ArrayCollection();
        $this->comments =  new ArrayCollection();
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Book
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
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
     * @return Book
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     */
    public function addComment(Comment $comment)
    {
        $this->comments->add($comment);
        $comment->setBook($this);
    }

    /**
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
        $comment->setBook(null);
    }

    /**
     * @param $comments
     * @return $this
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @return Author
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @param Author $author
     * @param bool $updateRelation
     * @return $this
     */
    public function addAuthor(Author $author, $updateRelation = true)
    {
        $this->authors[] = $author;
        if ($updateRelation) {
            $author->addBook($this, false);
        }

        return $this;
    }

    /**
     * @param Author $author
     * @param bool $updateRelation
     * @return $this
     */
    public function removeAuthor(Author $author, $updateRelation = true)
    {
        $this->authors->removeElement($author);
        if ($updateRelation) {
            $author->removeBook($this, false);
        }

        return $this;
    }

    /**
     * @param Author $authors
     * @return Book
     */
    public function setAuthor($authors)
    {
        $this->authors = $authors;
        return $this;
    }

    public function getAllAuthorsString()
    {
        if ($this->authors->count() == 1) {
            return $this->authors->first()->getFullName();
        }

        $authorsString = '';
        foreach ($this->authors as $author) {
            $authorsString.= $author->getFullName().' ,';
        }

        return $authorsString;
    }

    /**
     * @return Subcategory
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * @param Subcategory $subcategory
     * @return Book
     */
    public function setSubcategory($subcategory)
    {
        $this->subcategory = $subcategory;
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
     * @param UploadedFile $image
     * @return Book
     */
    public function setImage($image)
    {
        $this->image = $image;
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
     * @param string $imageUrl
     * @return Book
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
    public function getOldImageUrl()
    {
        return $this->oldImageUrl;
    }

    /**
     * @return UploadedFile
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param UploadedFile $document
     * @return Book
     */
    public function setDocument($document)
    {
        $this->document = $document;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentUrl()
    {
        return $this->documentUrl;
    }

    /**
     * @param string $documentUrl
     * @return Book
     */
    public function setDocumentUrl($documentUrl)
    {
        $this->oldDocumentUrl = $this->documentUrl;
        $this->documentUrl = $documentUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getOldDocumentUrl()
    {
        return $this->oldDocumentUrl;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     * @return Book
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
     * @return Book
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }


    /**
     * @return \DateTime
     */
    public function getAddDate()
    {
        return $this->addDate;
    }

    /**
     * @param \DateTime $addDate
     * @return Book
     */
    public function setAddDate($addDate)
    {
        $this->addDate = $addDate;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFeatured()
    {
        return $this->featured;
    }

    /**
     * @param $featured
     * @return $this
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMainFeatured()
    {
        return $this->mainFeatured;
    }

    /**
     * @param $mainFeatured
     * @return $this
     */
    public function setMainFeatured($mainFeatured)
    {
        $this->mainFeatured = $mainFeatured;

        return $this;
    }

    public function addLike($like)
    {
        $this->likes->add($like);

        return $this;
    }

    public function getLike()
    {
        return $this->likes;
    }

    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $likes;
    }

    public function removeLike($like)
    {
        $this->likes->removeElement($like);

        return $this->likes;
    }

    public function userLikeBook($user)
    {
        foreach($this->likes as $like){
            if($like->getUser()->getId() == $user->getId()){
                return true;
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!is_null($this->title)) {
            return $this->title;
        }

        return '';
    }
}