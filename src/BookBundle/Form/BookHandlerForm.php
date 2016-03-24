<?php

namespace BookBundle\Form;

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
            ->add('author','entity',array('class' => 'BookBundle\Entity\Author'));
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