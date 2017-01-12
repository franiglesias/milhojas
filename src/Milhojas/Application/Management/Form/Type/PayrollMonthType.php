<?php

namespace Milhojas\Application\Management\Form\Type;

use Milhojas\Domain\Management\PayrollMonth;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PayrollMonthType extends AbstractType implements DataMapperInterface
{
    /**
 * {@inheritdoc}
 */
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ->add('month', ChoiceType::class, array(
            'choices' => ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
        ))
        ->add('year', ChoiceType::class, array(
            'choices' => ['2016', '2017', '2018', '2019'],
        ))
        ->setDataMapper($this)
    ;
}

/**
 * {@inheritdoc}
 */
public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults([
        'data_class' => 'Milhojas\\Domain\\Management\\PayrollMonth',
    ]);
}

    public function mapDataToForms($data, $forms)
    {
        $forms = iterator_to_array($forms);
        $forms['month']->setData($data ? $data->getMonth() : '01');
        $forms['year']->setData($data ? $data->getYear() : '2017');
    }

    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        $data = new PayrollMonth(
        $forms['month']->getData(),
        $forms['year']->getData()
    );
    }
}
