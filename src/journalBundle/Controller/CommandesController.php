<?php

namespace journalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use journalBundle\Form\UtilisateursAdressesType; 
use journalBundle\Entity\UtilisateursAdresses;
use journalBundle\Entity\Produits;
use journalBundle\Entity\Commandes;

class CommandesController extends Controller {

    public function facture(){
        $session = $this->getRequest()->getSession(); 
        $em = $this->getDoctrine()->getManager(); 
        $generator = $this->container->get('security.secure_random');  
       
        $adresse = $session->get('adresse');
        $panier =  $session->get('panier');
        $commande = array(); 
        $totalHT = 0 ; 
        $totalTTC = 0 ; 
     
        
        $facturation = $em->getRepository('journalBundle:UtilisateursAdresses')->find($adresse['facturation']);
        $livraison = $em->getRepository('journalBundle:UtilisateursAdresses')->find($adresse['livraison']);
        $produits = $em->getRepository('journalBundle:Produits')->findArray(array_keys($session->get('panier')));
        
        foreach ($produits as $produit  ){
            $prixHT = ($produit->getPrix() *$panier[$produit->getId()] );
            $prixTTC =( ($produit->getPrix()*$panier[$produit->getId()] )*$produit->getTva()->getMultiplication() );
            $totalHT += $prixHT;
            $totalTTC +=$prixTTC ;
            if(!isset($commande['tva']['%'.$produit->getTva()->getValeur()]))
                $commande['tva']['%'.$produit->getTva()->getValeur()] = round(($prixTTC-$prixHT),2);
            else
                $commande['tva']['%'.$produit->getTva()->getValeur()] += round($prixTTC-$prixHT,2);
            
            $commande['produits'][$produit->getId()]=array('reference'=>$produit->getNom(),
                                                            'quantite'=> $panier[$produit->getId()],
                                                             'prixU'=> round($produit->getPrix(),2),
                                                              'prixTTC' => round($produit->getPrix() * $produit->getTva()->getMultiplication(),2));
                                                            
        }
           $commande['livraison']= array('prenom' =>$livraison->getPrenom() 
                                         ,'nom' => $livraison->getNom()
                                         ,'telephone'=> $livraison->getTelephone()
                                         ,'cp'=>  $facturation->getCp()  
                                         ,'adresse'=>  $livraison->getAdresse()
                                         ,'ville'=> $livraison->getVille()
                                         ,'pays'=>  $livraison->getPays()
                                         ,'complement'=>$livraison->getComplement() 
                                            );
        
            $commande['facturation']= array('prenom' =>$facturation->getPrenom() 
                                         ,'nom' => $facturation->getNom()
                                         ,'telephone'=> $facturation->getTelephone()
                                         ,'cp'=>  $facturation->getCp()
                                         ,'adresse'=>  $facturation->getAdresse()
                                         ,'ville'=> $facturation->getVille()
                                         ,'pays'=>  $facturation->getPays()
                                         ,'complement'=>$facturation->getComplement() 
                                                );
            $commande['totalHT'] = round($totalHT , 2); 
            $commande['totalTTC'] = round($totalTTC , 2); 
            $commande['token']=  bin2hex($generator->nextBytes(20));

           
        
        return $commande ; 
    }
    public function prepareCommandeAction(){
        $session = $this->getRequest()->getSession(); 
        $em = $this->getDoctrine()->getManager(); 
        
        if(!$session->has('commande'))
            $commande = new Commandes() ; 
        else
            $commande = $em->getRepository('journalBundle:Commandes')->find($session->get('commande'));
       if($commande==null ) return new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException("problème avec votre session");
          
        $commande->setDate(new \DateTime());
        $commande->setUtilisateur($this->container->get('security.context')->getToken()->getUser()); 
        $commande->setValider(0);
        $commande->setReference(0);
        $commande->setCommande($this->facture());
       
       
        if(!$session->has('commande')){
            $em->persist($commande);
            $session->set('commande',$commande);
            
        }
        $em->flush() ;
        return new Response($commande->getId());
    }
}
