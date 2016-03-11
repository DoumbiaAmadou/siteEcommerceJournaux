<?php
namespace journalBundle\Form ; 

use Symfony\Component\Form\AbstractType ; 
use Symfony\Component\Form\FormBuilderInterface;

class RechercheType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder , array $option  ) {
        $builder->add('recherche', 'text' , array('label'=>false , 'attr'=>array('class' =>'input-medium search-query'))); 
        
    }
    public function getName(){
        return 'journalBundle_recherche' ;
    }
    
}
