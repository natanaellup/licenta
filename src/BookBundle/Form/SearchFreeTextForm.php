<?php

namespace BookBundle\Form;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFreeTextForm extends AbstractType
{
    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * SearchFreeTextForm constructor.
     * @param $doctrine
     */
    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('freeText')
            ->add('author', 'entity', array(
                'class' => 'BookBundle\Entity\Author',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->where('a.active = 1')
                        ->orderBy('a.lastName', 'ASC');
                },
//                'choice_label' => 'Selecteaza un autor',
            ))
            ->add('subcategory', 'entity', array(
                'class' => 'BookBundle\Entity\Subcategory',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('subcat')
                        ->orderBy('subcat.name', 'ASC');
                }
            ));
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'search_free_text';
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BookBundle\Entity\FreeSearch',
        ));
    }
}
