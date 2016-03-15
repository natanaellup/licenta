<?php

namespace BookBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class AuthorAdmin extends Admin
{
    const IMAGE_DIR = 'uploads/author_image';

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('firstName')
            ->add('lastName')
            ->add('description')
            ->add('image', 'file',array('image_path' => 'imageUrl', 'image_style' => 'avatar_profile_edit'));
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('firstName')
            ->add('lastName');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('firstName');
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        $uploadService = $this->getConfigurationPool()->getContainer()->get('framework_extension.upload_manager');
        $uploadService->setDocumentUploadDir(self::IMAGE_DIR);
        $uploadService->setDocumentUrl($object,'getImage','setImage','setImageUrl','getOldImageUrl','author_image');
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        $uploadService = $this->getConfigurationPool()->getContainer()->get('framework_extension.upload_manager');
        $uploadService->setDocumentUploadDir(self::IMAGE_DIR);
        $uploadService->setDocumentUrl($object,'getImage','setImage','setImageUrl','getOldImageUrl','author_image');
    }

    /**
     * {@inheritdoc}
     */
    public function postRemove($object)
    {
        $uploadService = $this->getConfigurationPool()->getContainer()->get('framework_extension.upload_manager');
        $uploadService->removeDocument($object,'getImageUrl');
    }
}