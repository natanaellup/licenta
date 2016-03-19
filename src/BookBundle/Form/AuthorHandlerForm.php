<?php

namespace BookBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorHandlerForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName', 'text')
            ->add('description', 'textarea')
            ->add('image', 'file',array('image_path' => 'imageUrl', 'image_style' => 'avatar_profile_edit'));
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'add_author';
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BookBundle\Entity\Author',
        ));
    }
}