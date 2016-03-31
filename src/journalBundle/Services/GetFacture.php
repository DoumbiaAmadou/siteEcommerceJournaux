<?php

namespace journalBundle\Services;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Component\HttpKernel\Event;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GetFacture {

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function Facture($facture) {

//    if(!$facture){
////        $this->get('session')->getFlashBag()->add('errors', 'Cette Facture n\'existe pas !' );
////        return $this->redirect($this->generateUrl('factures'));
//    }else{
        if ($facture) {
            $html = $this->container->get('templating')->render('UtilisateurBundle:Default/layout/facturePDF.html.twig', array('facture' => $facture));
            $html2pdf = new \Html2Pdf_Html2Pdf('P', 'A4', 'fr');

            $html2pdf->pdf->SetAuthor('Site de Vente');
            $html2pdf->pdf->SetTitle('Facture ' . $facture->getReference());
            $html2pdf->pdf->SetSubject('Facture d\'achat de produits');
            $html2pdf->pdf->SetKeywords('facture,internet');
            $html2pdf->pdf->SetDisplayMode('real');
            $html2pdf->writeHTML($html);
//            $html2pdf->Output('Facture.pdf');

          return $html2pdf ; 
        }
    }

}
