<?php

namespace AppBundle\Form;

use AppBundle\Entity\Section;
use AppBundle\Entity\Task;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('section', EntityType::class, [
                'class' => Section::class
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'csrf_protection' => false,
                'data_class' => Task::class
            ]
        );
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_task_type';
    }
}
