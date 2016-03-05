<?php

namespace journalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }
    public function panierAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('journalBundle:Default/panier/layout/panier.html.twig');
    }
    public function livraisonAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('journalBundle:Default/panier/layout/livraison.html.twig');
    }
    public function validationAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('journalBundle:Default/panier/layout/validation.html.twig');
    }
}