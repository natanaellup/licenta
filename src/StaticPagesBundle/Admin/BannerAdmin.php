<?php

namespace StaticPagesBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use StaticPagesBundle\Entity\Banner as BannerEntity;

class BannerAdmin extends Admin
{
    /**
     * @inheritdoc
     */
    public function getFormBuilder()
    {
        $this->formOptions['data_class'] = $this->getClass();

        $options = $this->formOptions;

        if(!$this->getSubject() || is_null($this->getSubject()->getId())){
            $options['validation_groups'] = 'Add';
        }else{
            $options['validation_groups'] = 'Edit';
        }

        $formBuilder = $this->getFormContractor()->getFormBuilder( $this->getUniqid(), $options);

        $this->defineFormBuilder($formBuilder);

        return $formBuilder;
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->with('Detali',array('class' => 'col-md-6'))
            ->add('link')
            ->add('active')
            ->end()
            ->with('Imagine', array('class' => 'col-md-6'))
            ->add('image','file',array('image_path' => 'imageUrl', 'image_style' => 'avatar_profile_edit'))
            ->end();
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('link')
            ->add('imageUrl',null,array( 'template' => 'AdminOverrideBundle:Admin:avatar_list_field.html.twig', 'sortable' => false))
            ->add('active', null, array('editable' => true));
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
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
    }

    /**
     * Actiune care realizeaza upload-ul de documente si de poze pentru o carte.
     *
     * @param $object
     */
    protected function uploadAction($object)
    {
        $uploadService = $this->getConfigurationPool()->getContainer()->get('framework_extension.upload_manager');
        $uploadService->setDocumentUploadDir(BannerEntity::IMAGE_DIR_BOOK);
        $uploadService->setDocumentUrl($object,'getImage','setImage',
            'setImageUrl','getOldImageUrl',BannerEntity::NAME_PATH_IMAGE);
    }

}