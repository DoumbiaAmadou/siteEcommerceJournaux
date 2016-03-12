<?php

namespace journalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PanierController extends Controller {

    public function supprimerAction($id){
        $session = $this->getRequest()->getSession();  
        $panier = $session->get('panier');
        if(array_key_exists($id, $panier))
        {
            unset($panier[$id]); 
            $session->set('panier',$panier);
        }
   
        return $this->redirect($this->generateUrl('panier'));
    }
    public function ajouterAction($id) {
        $session = $this->getRequest()->getSession();
        if (!$session->has('panier'))
            $session->set('panier', array());
        $panier = $session->get('panier');

        //$panier[ID DU PRODUIT]=> QUANTITE  

        if ($this->getRequest()->query->get('qte') != null)
            $panier[$id] = $this->getRequest()->query->get('qte');
        else
            $panier[$id] = 1;

        $session->set('panier', $panier);
      //  var_dump($panier);
       // die() ; 
        return $this->redirect($this->generateUrl('panier'));
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction() {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }

    public function panierAction() {

        $session = $this->getRequest()->getSession();
        if (!$session->has('panier')) {
            $session->set('panier', array());
        }
        $em = $this->getDoctrine()->getManager();
        $panier = $session->get('panier');
        $produits = $em->getRepository('journalBundle:Produits')->findArray(array_keys($panier));

        return $this->render('journalBundle:Default/panier/layout/panier.html.twig',
                            array('produits' => $produits,
                            'panier' => $panier)
                            );
    }

    public function livraisonAction() {
        // replace this example code with whatever you need
        return $this->render('journalBundle:Default/panier/layout/livraison.html.twig');
    }

    public function validationAction() {
        // replace this example code with whatever you need
        return $this->render('journalBundle:Default/panier/layout/validation.html.twig');
    }

}
