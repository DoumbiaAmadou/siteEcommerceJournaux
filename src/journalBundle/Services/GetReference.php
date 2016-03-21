<?php
namespace journalBundle\Services; 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Component\HttpKernel\Event; 
use Symfony\Component\Security\Core\SecurityContextInterface; 

class GetReference{
    
    public function __construct($securityContext, $entityManager ){
        $this->securityContext = $securityContext;
       $this->em = $entityManager ;  
    }
    
    public function reference(){
      //  $route  = $event->getRequest()->attributes->get('_route');
            $reference = $this->em->getRepository('journalBundle:Commandes')->findOneBy(array('valider'=> 1) , array('id'=>'DESC'),1,1);
 //       if($route ==)
        if(!$reference)
            return 1 ; 
        else 
            return $reference->getReference()+1 ; 
    }
}