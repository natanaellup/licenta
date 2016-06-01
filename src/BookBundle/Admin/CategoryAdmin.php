<?php

namespace BookBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\Datagrid;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Knp\Menu\ItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

class CategoryAdmin extends Admin
{
    /**
     * Configure form fields.
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('name');
    }

    /**
     * Configure list fields.
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name');
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

    /**
     * {@inheritdoc}
     */
    public function configureSideMenu(ItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, array('edit'))) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;

        $elementId = $admin->getSubject()->getId();

        $menu->addChild('Categoria curenta',
            $admin->generateMenuUrl('edit', array('id' => $elementId))
        );

        $menu->addChild('Subcategorii', $admin->generateMenuUrl(
            'bookbundle.subcategory_admin.list', array('id' => $elementId)
        ));
    }
}