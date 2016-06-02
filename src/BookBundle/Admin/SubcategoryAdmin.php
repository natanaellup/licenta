<?php

namespace BookBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SubcategoryAdmin extends Admin
{

    protected $parentAssociationMapping = 'category';

    /**
     * Configure list fields.
     *
     * @param ListMapper $list
     */
    public function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('name');
    }

    /**
     * Configure form fields.
     *
     * @param FormMapper $form
     */
    public function configureFormFields(FormMapper $form)
    {
        $form->add('name')
            ->add('description', 'textarea');
    }

    /**
     * Configure data grid filters.
     *
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDataGridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
    }
}