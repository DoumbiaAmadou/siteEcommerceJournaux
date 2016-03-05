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
        // replace this example code with whatever you need
        return $this->render('journalBundle:Default/Produits/layout/produits.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
     public function produitAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('journalBundle:Default/Produits/layout/produitsolo.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
}