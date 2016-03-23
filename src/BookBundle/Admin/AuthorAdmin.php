<?php

namespace BookBundle\Admin;


use BookBundle\Entity\Author;
use Doctrine\DBAL\Query\QueryBuilder;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class AuthorAdmin extends Admin
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
    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('firstName')
            ->add('lastName')
            ->add('description')
            ->add('image', 'file',array('image_path' => 'imageUrl', 'image_style' => 'avatar_profile_edit'))
            ->add('active');
    }

    /**
     * {@inheritdoc}
     */
    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('firstName')
            ->add('lastName')
            ->add('imageUrl',null,array(
                    'template' => 'AdminOverrideBundle:Admin:avatar_list_field.html.twig',
                    'sortable' => false
                )
            )
            ->add('active','boolean',array('editable' => true));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('firstName', 'doctrine_orm_callback', array(
                                'label' => 'First Name or Last Name',
                                'callback' => function ($queryBuilder, $alias, $field, $value) {
                                    if (empty($value['value'])) {
                                        return false;
                                    }
                                    /** @var QueryBuilder $queryBuilder */
                                    $queryBuilder->andWhere('o.firstName LIKE :value OR o.lastName LIKE :value');
                                    $queryBuilder->setParameter('value','%'.$value['value'].'%');

                                    return true;
                                }
                            ))
                        ->add('active');
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        $uploadService = $this->getConfigurationPool()->getContainer()->get('framework_extension.upload_manager');
        $uploadService->setDocumentUploadDir(Author::IMAGE_DIR);
        $uploadService->setDocumentUrl($object,'getImage','setImage','setImageUrl','getOldImageUrl',Author::NAME_PATH);
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        $uploadService = $this->getConfigurationPool()->getContainer()->get('framework_extension.upload_manager');
        $uploadService->setDocumentUploadDir(Author::IMAGE_DIR);
        $uploadService->setDocumentUrl($object,'getImage','setImage','setImageUrl','getOldImageUrl',Author::NAME_PATH);

        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $object->setUser($user);
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