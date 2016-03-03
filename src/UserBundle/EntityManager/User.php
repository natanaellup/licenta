<?php

namespace UserBundle\EntityManager;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use FrameworkExtensionBundle\Filesystem\UploadManager;
use UserBundle\Entity\User as UserEntity;


class User implements EventSubscriber
{
    /**
     * @var UploadManager
     */
    protected $uploadManager;

    /**
     * User constructor.
     * @param UploadManager $uploadManager
     */
    public function __construct($uploadManager)
    {
        $this->uploadManager = $uploadManager;
    }

    /**
     * @inheritdoc
     */
    public function getSubscribedEvents()
    {
       return array('prePersist','preUpdate','postRemove');
    }

    /**
     * PreUpdate event.
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $user = $eventArgs->getObject();

        if ($user instanceof UserEntity) {
            $this->uploadManager->setDocumentUploadDir('user_avatar');
            $this->uploadManager->setDocumentUrl($user,'getAvatar','setAvatar','setAvatarUrl','getOldAvatarUrl','avatar');
        }
    }

    /**
     * PrePersist event.
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $user = $eventArgs->getObject();

        if ($user instanceof UserEntity) {
            $this->uploadManager->setDocumentUploadDir('user_avatar');
            $this->uploadManager->setDocumentUrl($user,'getAvatar','setAvatar','setAvatarUrl','getOldAvatarUrl','avatar');
        }
    }

    /**
     * Post remove event.
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function postRemove(LifecycleEventArgs $eventArgs)
    {
        $user = $eventArgs->getObject();

        if($user instanceof UserEntity){
            $this->uploadManager->removeDocument($user,'getAvatarUrl');
        }
    }
}