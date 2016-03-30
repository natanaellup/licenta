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
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('title')
            ->add('authors')
            ->add('imageUrl',null,array( 'template' => 'AdminOverrideBundle:Admin:avatar_list_field.html.twig', 'sortable' => false))
            ->add('document',null,array('template' => 'BookBundle:Admin:book_document_field_list.html.twig'))
            ->add('active','boolean',array('sortable => true','editable' => true));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $form)
    {
        $em = $this->modelManager->getEntityManager('BookBundle\Entity\Author');

        $query = $em->createQueryBuilder('a')
            ->select('a')
            ->from('BookBundle:Author', 'a')
            ->where('a.active = 1');

        $form->add('title')
            ->add('description')
            ->add('image','file',array('image_path' => 'imageUrl', 'image_style' => 'avatar_profile_edit'))
            ->add('document','file',array('file_path' => 'documentUrl','file_name' => 'title'))
            ->add('category')
            ->add('authors','sonata_type_model', array('by_reference' => false, 'multiple' => true, 'query' => $query,
                            'choice_translation_domain' => false))
            ->add('active');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title')
                ->add('authors')
                ->add('active');
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