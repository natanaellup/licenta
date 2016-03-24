<?php

namespace BookBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use BookBundle\Entity\Book as BookEntity;

class BookAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('title')
            ->add('description')
            ->add('image','file',array('image_path' => 'imageUrl', 'image_style' => 'avatar_profile_edit'))
            ->add('document','file',array('file_path' => 'documentUrl','file_name' => 'title'))
            ->add('category')
            ->add('author')
            ->add('active');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        $dt = new \DateTime();
        $dt->format('Y-m-d H:i:s');
        $object->setAddDate($dt);

        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $object->setUser($user);

        $this->uploadAction($object);
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        $this->uploadAction($object);
    }

    /**
     * {@inheritdoc}
     */
    public function postRemove($object)
    {
        $uploadService = $this->getConfigurationPool()->getContainer()->get('framework_extension.upload_manager');
        $uploadService->removeDocument($object,'getImageUrl');
        $uploadService->removeDocument($object,'getDocumentUrl');
    }

    /**
     * Actiune care realizeaza upload-ul de documente si de poze pentru o carte.
     *
     * @param $object
     */
    protected function uploadAction($object)
    {
        $uploadService = $this->getConfigurationPool()->getContainer()->get('framework_extension.upload_manager');
        $uploadService->setDocumentUploadDir(BookEntity::IMAGE_DIR_BOOK);
        $uploadService->setDocumentUrl($object,'getImage','setImage',
            'setImageUrl','getOldImageUrl',BookEntity::NAME_PATH_IMAGE);

        $uploadService->setDocumentUploadDir(BookEntity::DOCUMENT_DIR_BOOK);
        $uploadService->setDocumentUrl($object,'getDocument','setDocument',
            'setDocumentUrl','getOldDocumentUrl',BookEntity::NAME_PATH_DOCUMENT);
    }
}