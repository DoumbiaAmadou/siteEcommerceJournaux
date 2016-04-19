<?php

namespace journalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateursAdressesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('adresse')
            ->add('cp',null ,array('attr'=> array('class'=>'cp' ,'maxlength'=> 5)))
            ->add('ville',null ,array('attr'=> array('class'=>'ville')))
            ->add('pays',null ,array('attr'=> array('class'=>'pays')))
            ->add('complement', null ,array('required'=>false))
           // ->add('utilisateur')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'journalBundle\Entity\UtilisateursAdresses'
        ));
    }
}
