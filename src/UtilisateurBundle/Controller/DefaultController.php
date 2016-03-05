<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use journalBundle\Entity\Produits;
use UtilisateurBundle\Form\TestType;

class DefaultController extends Controller
{   
    public function testformulaireAction()
    {
        $form = $this->createForm(new TestType());
        
        return $this->render('UtilisateurBundle:Default:index.html.twig',array('form'=>$form->createView()));
    }
    public function indexAction()
    {
        return $this->render('UtilisateurBundle:Default:index.html.twig');
    }
    
   
}
