<?php

namespace Milhojas\Infrastructure\Ui\Management\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

class PayrollType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('month', PayrollMonthType::class)
            ->add('file', FileType::class, array(
                'label' => 'ZIP File',
                'multiple' => true,
                'constraints' => array(
                     new All(array(
                         'constraints' => array(
                             new File(array(
                                 'maxSize' => 60000000,
                             )),
                         ),
                     )),
                ),

            ))
        ;
    }
}
