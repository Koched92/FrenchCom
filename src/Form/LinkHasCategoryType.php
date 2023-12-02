<?php

namespace App\Form;

use App\Entity\LinkHasCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkHasCategoryType extends AbstractType
{
    /**
     * @SuppressWarnings(UnusedFormalParameter)
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categoryGroup')
            ->add('category');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LinkHasCategory::class,
        ]);
    }
}
