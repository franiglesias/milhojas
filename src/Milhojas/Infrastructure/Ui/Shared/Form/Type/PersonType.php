<?php

namespace Milhojas\Infrastructure\Ui\Shared\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Milhojas\Infrastructure\Ui\Shared\Form\Data\PersonData;

class PersonType extends AbstractType implements DataMapperInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('gender', ChoiceType::class, array(
                'choices' => [
                    'varón' => 'male',
                    'mujer' => 'female',
                    ],
                'expanded' => true,
                'multiple' => false,
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
            'data_class' => PersonData::class,
        ]);
    }

    public function mapDataToForms($data, $forms)
    {
        $forms = iterator_to_array($forms);
        $forms['name']->setData($data ? $data->getName() : '');
        $forms['surname']->setData($data ? $data->getSurname() : '');
        $forms['gender']->setData($data ? $data->getGender() : '');
    }

    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        $data = new PersonData();
        $data->setName($forms['name']->getData());
        $data->setSurname($forms['surname']->getData());
        $data->setGender($forms['gender']->getData());
    }
}
