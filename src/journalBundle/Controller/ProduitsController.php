<?php

namespace journalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use journalBundle\Form\RechercheType ; 
use journalBundle\Entity\categorie ;
class ProduitsController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */

    public function presentationAction (categorie $categorie =null)
    {
        //var_dump($categorie);
       // die();
         $em = $this->getDoctrine()->getManager();
         $session = $this->getRequest()->getSession();
         if ($categorie == null) {
            $produits = $em->getRepository('journalBundle:Produits')->findBy(array('disponible' => 1));
        } else {
            $produits = $em->getRepository('journalBundle:Produits')->findByCategorie($categorie);
        }
        if($session->has('panier'))
        {
            $panier = $session->get('panier'); 
        }else 
             $panier = false ; 
        if(!$produits) 
            throw $this->createNotFoundException("Cette pages n'existe pas");
        
        return $this->render('journalBundle:Default/Produits/layout/produits.html.twig', array('Produits' => $produits,'panier'=> $panier));
    
      
    }
     public function produitAction( $id)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->getRequest()->getSession();
        if (!$session->has('panier')) {
            $session->set('panier', array());
        }
        $panier = $session->get('panier');
        $produits = $em->getRepository('journalBundle:Produits')->find($id);
        if(!$produits)
          throw $this->createNotFoundException("Cette pages n'existe pas");
      
        // replace this example code with whatever you need
        return $this->render('journalBundle:Default/Produits/layout/produitsolo.html.twig', array('Produit' => $produits , 'panier'=>$panier ));
    }
   /*  public function categorieAction($categorie)
     {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('journalBundle:Produits')->findByCategorie($categorie);
        if(!$produits) 
            throw $this->createNotFoundException("Cette pages n'existe pas");
        
        return $this->render('journalBundle:Default/Produits/layout/produits.html.twig', array('Produits' => $produits));
   
     }*/
    public function rechercheAction(){
        
        $form = $this->createForm(new RechercheType());
        return $this->render('journalBundle:Default/recherche/modulesUsed/recherche.html.twig', array('form' => $form->createView()));
    }
    public function rechercheTraitementAction(){
         
        $form = $this->createForm(new RechercheType());
        if($this->get('request')->getmethod()=='POST'){
            $form->bind($this->get('request'));
            $em = $this->getDoctrine()->getManager();
            $produits = $em->getRepository('journalBundle:Produits')->recherche($form['recherche']->getData());
            
         } else 
          throw $this->createNotFoundException ("Cette page n'existe pas disponible!");
                 return $this->render('journalBundle:Default/Produits/layout/produits.html.twig', array('Produits' => $produits));
 
    }
}