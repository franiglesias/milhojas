<?php

namespace Milhojas\Infrastructure\Ui\Shared\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('person', PersonType::class)
            ->add('save', SubmitType::class, array('label' => 'Dar de alta', 'attr' => array('class' => 'button expanded')))
        ;
    }
}
