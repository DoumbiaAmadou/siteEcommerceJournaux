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

class CommandesAdminController extends Controller {

    public function commandesAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $categories = $em->getRepository("journalBundle:Commandes")->findAll();

        return $this->render('journalBundle:Administration/Commandes/index.html.twig', array('commandes' => $categories));
    }

    public function showFactureAction($id) {

        $em = $this->getDoctrine()->getEntityManager();
        $facture = $em->getRepository('journalBundle:Commandes')->findOneBy(array('utilisateur' => $this->getUser(),
            'valider' => 1,
            'id' => $id));

        if (!$facture) {
            $this->get('session')->getFlashBag()->add('errors', 'Cette Facture n\'existe pas !');
            return $this->redirect($this->generateUrl('factures'));
        }
         $html2pdf=$this->container->get('getFacture')->facture($facture);
        $html2pdf->Output('Facture.pdf');
        $response = new Response();
        $response->headers->set('Content-type', 'application/pdf');

        return $response;
    }

}
