<?php

namespace journalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategorieController extends Controller {

    public function menuAction() {
        $em = $this->getDoctrine()->getManager();
        $pages = $em->getRepository('journalBundle:categorie')->findAll();

        return $this->render('journalBundle:Default/categorie/modulesUsed/menu.html.twig', array('categories' => $pages));
    }

    public function pagesAction($id) {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('PagesBundle:Pages')->find($id);
        if(!$page) 
            throw $this->createNotFoundException("Cette pages n'existe pas");
        
        return $this->render('PagesBundle:Default/pages/layout/pages.html.twig', array('page' => $page));
    }

}
