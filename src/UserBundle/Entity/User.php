<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


class User extends BaseUser
{

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

    public function __construct()
    {
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

    /**
     * Get avatar url.
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }

    /**
     * Set avatarUrl.
     *
     * @param $avatarUrl
     * @return $this
     */
    public function setAvatarUrl($avatarUrl)
    {
        $this->avatarUrl = $avatarUrl;
        return $this;
    }
}

