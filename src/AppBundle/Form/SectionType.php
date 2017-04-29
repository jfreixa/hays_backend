<?php

namespace AppBundle\Form;

use AppBundle\Entity\Section;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'csrf_protection' => false,
                'data_class' => Section::class
            ]
        );
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_section_type';
    }
}
