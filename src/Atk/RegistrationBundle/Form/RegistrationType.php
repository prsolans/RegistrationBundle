<?php

namespace Atk\RegistrationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('eventdate')
            ->add('timeslot')
            ->add('add1')
            ->add('add2')
            ->add('add3')
            ->add('add4')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Atk\RegistrationBundle\Entity\Registration'
        ));
    }

    public function getName()
    {
        return 'atk_registrationbundle_registration';
    }
}
