<?php

namespace Milhojas\Application\Management\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PayrollType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('month', TextType::class)
            ->add('completed', DateType::class)
			->add('file', FileType::class, array('label' => 'ZIP File'))
            ->add('save', SubmitType::class, array('label' => 'Start Payroll'))
        ;
    }
}

?>
