<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UtilisateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBulderInterface;

class TestType extends AbstractType {

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options) {
        /*         * *
         * Nous allons faire notre formulaire de teste
         * 
         */
        $builder->add('email')
                ->add('nom')
                ->add('prenom')
                ->add('sexe')
                ->add('sexe')
                ->add('envoyer');
        // parent::buildForm($builder, $options);
    }

    public function getName() {
        return 'ajout_produit';
    }

}
