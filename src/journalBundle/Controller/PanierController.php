<?php

namespace journalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use journalBundle\Form\UtilisateursAdressesType; 
use journalBundle\Entity\UtilisateursAdresses; 

class PanierController extends Controller {

     public function menuAction(){
        $session = $this->getRequest()->getSession();  
      
        if(!$session->has('panier'))
            $articles = 0 ;
          else 
              $articles = count($session->get('panier'));
          
        return $this->render('journalBundle:Default/panier/modulesUsed/menu.html.twig',
                            array('articles' => $articles));
    }
    public function livraisaonSuppressionAdresseAction($id){
        
        $em = $this->getDoctrine()->getManager();
        $realUser=  $em->getRepository('journalBundle:UtilisateursAdresses')->find($id);
        if($this->container->get('security.context')->gettoken()->getUser()!=$realUser->getUtilisateur() || !$realUser ){
            die();
            $this->redirect($this->generateUrl('livraison'));
        }
       
        $em->remove($realUser);
        $em->flush(); 
        return $this->redirect($this->generateUrl('livraison'));
    }
    public function supprimerAction($id){
        $session = $this->getRequest()->getSession();  
        $panier = $session->get('panier');
        if(array_key_exists($id, $panier))
        {
            unset($panier[$id]); 
            $session->set('panier',$panier);
            $session->getFlashBag()->add('succes' , ' Article supprimé avec succès' );
        }
   
        return $this->redirect($this->generateUrl('panier'));
    }
    public function ajouterAction($id) {
        $session = $this->getRequest()->getSession();
        if (!$session->has('panier'))
                $session->set('panier', array());
        $panier = $session->get('panier');

        //$panier[ID DU PRODUIT]=> QUANTITE  

        if ($this->getRequest()->query->get('qte') != null){
            $panier[$id] = $this->getRequest()->query->get('qte');
            $session->getFlashBag()->add('succes' , ' Quantité  Modifié avec succès' );
        }
        else
            if(array_key_exists($id, $panier)){
                $panier[$id] = $panier[$id] +1;  
             $session->getFlashBag()->add('succes' , ' Quantité  Modifié avec succès' );
            }
           else{
                $panier[$id] = 1;
                 $session->getFlashBag()->add('succes' , ' Article  ajouté avec succès' );
           }
        $this->getRequest()->getSession()->set('panier', $panier);
          
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
        $em = $this->getDoctrine()->getManager();
        $user= $this->container->get('security.context')->getToken()->getUser(); 
        $entite = new UtilisateursAdresses(); 
        $form = $this->createForm( new UtilisateursAdressesType()  , $entite); 
        
        if($this->get('request')->getMethod()=='POST'){
            $form->handleRequest($this->getRequest()); 
            if($form->isValid())
            {
                $entite->setUtilisateur($user);
                $em->persist($entite);
                $em->flush(); 
                
                return $this->redirect($this->generateUrl('livraison'));
            }
        }
        return $this->render('journalBundle:Default/panier/layout/livraison.html.twig', 
                array('utilisateurs' =>  $user,'form'=> $form->createView()) );
    }
    public function setLivraisionOnSession(){
        $session = $this->get('request')->getSession() ; 
            if(!$session->has('adresse'))
                $session->set('adresse', array());
            $adresse = $session->get('adresse'); 
        
            if ($this->getRequest()->request->get('livraison') != null 
                    && $this->getRequest()->request->get('facturation') != null) 
                {
                    $adresse['facturation'] = $this->getRequest()->request->get('facturation');
                    $adresse['livraison'] = $this->getRequest()->request->get('facturation');
     
                }
                else
                    return $this->redirect ($this->generateUrl ('validation'));
        
        $session->set('adresse',$adresse);
        return $this->redirect($this->generateUrl('validation'));
        
    }

    public function validationAction() {
       $em = $this->getDoctrine()->getManager();
       
       if ($this->get('request')->getMethod() == 'POST') {
            $this->setLivraisionOnSession();
        }

        $prepareCommande = $this->forward('journalBundle:Commandes:prepareCommande');
       $commande = $em->getRepository('journalBundle:Commandes')->find($prepareCommande->getContent());
       
       
       $em= $this->getDoctrine()->getManager();  
       $session = $this->getRequest()->getSession(); 
       $adresse = $session->get('adresse');
     /*  
       $produits = $em->getRepository('journalBundle:Produits')->findArray(array_keys($session->get('panier')));
       $livraison = $em->getRepository('journalBundle:UtilisateursAdresses')->find($adresse['livraison']);
       $facturation = $em->getRepository('journalBundle:UtilisateursAdresses')->find($adresse['facturation']);
        */
       

   
       return $this->render('journalBundle:Default/panier/layout/validation.html.twig' ,
             array('Commande'=>$commande));
    
       
    }

}
