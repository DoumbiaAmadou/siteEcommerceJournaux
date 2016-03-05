<?php

namespace PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagesController extends Controller
{
    public function pagesAction($id)
    {
        return $this->render('PagesBundle:Default/pages/layout/pages.html.twig');
    }
}
