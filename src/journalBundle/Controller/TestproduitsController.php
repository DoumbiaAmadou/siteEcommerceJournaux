<?php

namespace journalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use journalBundle\Entity\Produits;

class TestproduitsController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function ajoutAction (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // replace this example code with whatever you need
      /*  $produit = new Produits();
        $produit->setCategorie('Abonnements');
        $produit->setNom('MALI Kunafoi');
        $produit->setTva(20.0);
        $produit->setDisponible(true);
        $produit->setPrix(100);
        $produit->setImages('https://image.jimcdn.com/app/cms/image/transf/none/path/s93a089e570be78ac/image/ib54d37d2d21fee1b/version/1391425495/image.png');*/
      /*    $produit = new Produits();
        $produit->setCategorie('Achats');
        $produit->setNom('Essor');
        $produit->setTva(20.0);
        $produit->setDisponible(true);
        $produit->setPrix(100);
        $produit->setImages('http://www.essor.ml/wp-content/themes/essor/images/logo-dark.png');*/

       /* $em->persist($produit);
        $em->flush(); 
      */

       $produits =  $em->getRepository('journalBundle:Produits')->findAll(); 
       



        return $this->render('journalBundle:Default/produits/layout/test.html.twig'  ,  array('produits' => $produits, ));
    }
    
}