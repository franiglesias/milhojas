<?php

namespace Milhojas\Application\Management\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

class PayrollType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('month', TextType::class)
            ->add('completed', DateType::class)
			->add('file', FileType::class, array(
				'label' => 'ZIP File', 
				'multiple' => true, 
		        'constraints' => array(
		             new All(array( // Validates each an every entry in the array that is uploaded with the given constraints.
		                 'constraints' => array(
		                     new File(array(
		                         'maxSize' => 6000000
		                     )),
		                 ),
		             )),
				)
 
			))
            ->add('save', SubmitType::class, array('label' => 'Start Payroll'))
        ;
    }
}

?>