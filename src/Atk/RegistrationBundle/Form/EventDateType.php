<?php

namespace Atk\RegistrationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventDateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eventdate')
            ->add('event')
            ->add('timeIncrement')
            ->add('status')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Atk\RegistrationBundle\Entity\EventDate'
        ));
    }

    public function getName()
    {
        return 'atk_registrationbundle_eventdate';
    }
}
