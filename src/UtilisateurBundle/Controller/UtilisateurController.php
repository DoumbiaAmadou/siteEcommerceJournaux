<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use journalBundle\Entity\Produits;

use UtilisateurBundle\Form\TestType;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class UtilisateurController extends Controller {

    public function testformulaireAction() {
        $form = $this->createForm(new TestType());

        return $this->render('UtilisateurBundle:Default:index.html.twig', array('form' => $form->createView()));
    }

    public function facturesAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $factures = $em->getRepository('journalBundle:Commandes')->byFacture($this->getUser());

        return $this->render('UtilisateurBundle:Default/layout/facture.html.twig', array("factures" => $factures));
    }

    public function generateFacturePDFAction($id) {

        $em = $this->getDoctrine()->getEntityManager();
        $facture = $em->getRepository('journalBundle:Commandes')->findOneBy(
                array('utilisateur' => $this->getUser(),
            'valider' => 1,
            'id' => $id));

        if (!$facture) {
            $this->get('session')->getFlashBag()->add('errors', 'Cette Facture n\'existe pas !');
            return $this->redirect($this->generateUrl('factures'));
        }
       $html2pdf= $this->container->get('getFacture')->facture($facture);
        $html2pdf->Output('Facture.pdf');
        $response = new Response();
        $response->headers->set('Content-type', 'application/pdf');

        return $response;
    }
    public function villesAction($cp){
       $em = $this->getDoctrine()->getEntityManager();
//         $villes = $em->getRepository('journalBundle:Commandes')->byFacture($this->getUser());
        $villes = $em->getRepository('UtilisateurBundle:Villes')->getCp($cp); 
//                array("villeCodePostal" => $cp)
//                );
      
        $res = new JsonResponse(); 
       
        if ($villes) {
               $res->setData(array('villes'=> $villes->getVilleNom()));
        } else {
           $res->setData(array('villes'=> ''));
        }
        return $res; 
    }
}

