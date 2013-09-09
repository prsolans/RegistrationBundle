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
            ->add('firstname', null, array('label'  => 'First Name: '))
            ->add('lastname', null, array('label'  => 'Last Name: '))
            ->add('email', null, array('label'  => 'Email: '))
            ->add('eventdate', null, array('label'  => 'Date: '))
            ->add('timeslot', null, array('label'  => 'Time Name: '))
            ->add('add1', null, array('label'  => 'Info 1: '))
            ->add('add2', null, array('label'  => 'Info 2: '))
            ->add('add3', null, array('label'  => 'Info 3: '))
            ->add('add4', null, array('label'  => 'Info 4: '))
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
