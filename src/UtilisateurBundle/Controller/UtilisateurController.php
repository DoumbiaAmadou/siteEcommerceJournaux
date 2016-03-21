<?php

namespace UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use journalBundle\Entity\Produits;
use UtilisateurBundle\Form\TestType;
use \Symfony\Component\HttpFoundation\Response;


class UtilisateurController extends Controller
{
public function testformulaireAction()
{
$form = $this->createForm(new TestType());

return $this->render('UtilisateurBundle:Default:index.html.twig', array('form' => $form->createView()));
}
public function facturesAction()
{
    $em = $this->getDoctrine()->getEntityManager();
    $factures = $em->getRepository('journalBundle:Commandes')->byFacture($this->getUser());

    return $this->render('UtilisateurBundle:Default/layout/facture.html.twig', array("factures" => $factures));
}
public function generateFacturePDFAction($id){

    $em = $this->getDoctrine()->getEntityManager();
    $facture = $em->getRepository('journalBundle:Commandes')->findOneBy(array('utilisateur'=> $this->getUser(),
                                                                'valider' => 1,
                                                                 'id' => $id));

    if(!$facture){
        $this->get('session')->getFlashBag()->add('errors', 'Cette Facture n\'existe pas !' );
        return $this->redirect($this->generateUrl('factures'));
    }
    
    $html = $this->renderView('UtilisateurBundle:Default/layout/facturePDF.html.twig', array('facture'=> $facture)); 
    $html2pdf = new \Html2Pdf_Html2Pdf('P','A4','fr');
  
    $html2pdf->pdf->SetAuthor('Site de Vente');
    $html2pdf->pdf->SetTitle('Facture '.$facture->getReference());
    $html2pdf->pdf->SetSubject('Facture d\'achat de produits');
    $html2pdf->pdf->SetKeywords('facture,internet');
    $html2pdf->pdf->SetDisplayMode('real');
    $html2pdf->writeHTML($html);
    $html2pdf->Output('Facture.pdf'); 
    
    $response = new Response() ;
    $response->headers->set('Content-type' , 'application/pdf');
    
    return $response ; 

    
}

}
