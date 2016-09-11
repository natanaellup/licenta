<?php

namespace UserBundle\Entity;

use ActivityBundle\Entity\Comment;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class User extends BaseUser
{

    /**
     * Default photo url.
     */
    const DEFAULT_PHOTO_URL = 'uploads/user_avatar/avatar-default.png';

    /**
     * User id.
     *
     * @var integer
     */
    protected $id;

    /**
     * User birthday.
     *
     * @var \DateTime
     */
    protected $birthday;

    /**
     * Avatar url.
     *
     * @var string
     */
    protected $avatarUrl;

    /**
     * Old avatar path.
     *
     * @var string
     */
    protected $oldAvatarUrl;

    /**
     * @var UploadedFile
     */
    protected $avatar;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var ArrayCollection
     */
    protected $comments;

    /**
     * @var ArrayCollection
     */
    protected $likes;

    /**
     * @var ArrayCollection
     */
    protected $readers;

    /**
     * @var ArrayCollection
     */
    protected $wishlists;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->comments =  new ArrayCollection();
        $this->readers = new ArrayCollection();
        $this->wishlists =  new ArrayCollection();
        parent::__construct();
    }

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get user birthday.
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set user birthday.
     *
     * @param \DateTime $birthday
     * @return $this
     */
    public function setBirthday(\DateTime $birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get avatar url.
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        if(!is_null($this->avatarUrl)){
            return $this->avatarUrl;
        }

        return self::DEFAULT_PHOTO_URL;
    }

    /**
     * Set avatarUrl.
     *
     * @param $avatarUrl
     * @return $this
     */
    public function setAvatarUrl($avatarUrl)
    {
        $this->oldAvatarUrl = $this->avatarUrl;
        $this->avatarUrl = $avatarUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getOldAvatarUrl()
    {
        return $this->oldAvatarUrl;
    }

    /**
     * @param string $oldAvatarUrl
     * @return User
     */
    public function setOldAvatarUrl($oldAvatarUrl)
    {
        $this->oldAvatarUrl = $oldAvatarUrl;
        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param UploadedFile $avatar
     * @return User
     */
    public function setAvatar($avatar = null)
    {
        $this->avatar = $avatar;
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
        $comment->setUser($this);
    }

    /**
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
        $comment->setUser(null);
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


    public function getReaders()
    {
        return $this->readers;
    }

    public function setReaders($readers)
    {
        $this->readers = $readers;

        return $this;
    }

    public function addReader($reader)
    {
        $this->readers->add($reader);

        return $this;
    }

    public function removeReader($reader)
    {
        $this->readers->removeElement($reader);

        return $this;
    }

    public function getWishlists()
    {
        return $this->wishlists;
    }

    public function setWishlists($wishlist)
    {
        $this->wishtlists = $wishlist;

        return $this;
    }

    public function addWishlist($wishlist)
    {
        $this->wishlist->add($wishlist);

        return $this;
    }

    public function removeWishlist($wishlist)
    {
        $this->wishlists->removeElement($wishlist);

        return $this;
    }

}

