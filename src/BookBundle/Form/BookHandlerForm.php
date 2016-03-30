<?php

namespace BookBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookHandlerForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('description', 'textarea')
            ->add('image', 'file',array('image_path' => 'imageUrl', 'image_style' => 'avatar_profile_edit'))
            ->add('document','file',array('file_path' => 'documentUrl','file_name' => 'title'))
            ->add('category','entity',array('class' => 'BookBundle\Entity\Category'))
            ->add('authors','entity',array(
                    'class' => 'BookBundle\Entity\Author',
                    'multiple' => true,
                    'by_reference' => true,
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                            ->where('a.active = 1')
                            ->orderBy('a.firstName', 'ASC');
                    })
            );
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'handle_book';
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BookBundle\Entity\Book',
        ));
    }
}