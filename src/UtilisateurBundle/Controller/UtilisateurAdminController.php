<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use journalBundle\Entity\Produits;
use UtilisateurBundle\Form\TestType;
use \Symfony\Component\HttpFoundation\Response;

class UtilisateurAdminController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $utilisateurs = $em->getRepository('UtilisateurBundle:Utilisateur')->findAll();

        return $this->render('UtilisateurBundle:Administration/utilisateur/layout/index.html.twig', array("utilisateurs" => $utilisateurs));
    }
      public function adressesAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $utilisateur = $em->getRepository('UtilisateurBundle:Utilisateur')->find($id);
        $route=  $this->container->get('request')->get('_route'); 
        
      if($route==='AdminAdresse')
        return $this->render('UtilisateurBundle:Administration/utilisateur/layout/adresse.html.twig', array("utilisateur" => $utilisateur));
    if($route=== 'AdminUtilisateur')
       return $this->render('UtilisateurBundle:Administration/utilisateur/layout/facture.html.twig', array("utilisateur" => $utilisateur));
   else {
    throw $this->createNotFoundException("La page n'existe pas!");
   }
   }
   public function factureAction($id){
       $em = $this->getDoctrine()->getEntityManager(); 
       $facture = $em->getRepository('journalBundle:Commandes')->find($id);
       return $this->container->get('getFacture')->facture($facture);
   }
     
}
