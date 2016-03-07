<?php

namespace journalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProduitsController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function presentationAction (Request $request)
    {
         $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('journalBundle:Produits')->findAll();
     
        // replace this example code with whatever you need
        return $this->render('journalBundle:Default/Produits/layout/produits.html.twig', array('Produits' => $produits));
    }
     public function produitAction( $id)
    {
            $em = $this->getDoctrine()->getManager();
            $produits = $em->getRepository('journalBundle:Produits')->find($id);
     
        // replace this example code with whatever you need
        return $this->render('journalBundle:Default/Produits/layout/produitsolo.html.twig', array('Produit' => $produits));
    }
     public function categorieAction($categorie)
     {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('journalBundle:Produits')->findByCategorie($categorie);
        if(!$produits) 
            throw $this->createNotFoundException("Cette pages n'existe pas");
        
        return $this->render('journalBundle:Default/Produits/layout/produits.html.twig', array('Produits' => $produits));
   
     }
}