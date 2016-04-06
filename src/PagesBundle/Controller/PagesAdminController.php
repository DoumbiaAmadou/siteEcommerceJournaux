<?php

namespace PagesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PagesBundle\Entity\Pages;
use PagesBundle\Form\PagesType;

/**
 * pages controller.
 *
 */
class PagesAdminController extends Controller
{
    /**
     * Lists all pages entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('PagesBundle:Pages')->findAll();
        $pagefind = $this->get('knp_paginator')->paginate($pages , $this->get('request')->query->get('page', 1), 6);

        return $this->render('PagesBundle:Administration/pages/layout/index.html.twig', array(
            'pages' => $pagefind,
        ));
    }

    /**
     * Creates a new pages entity.
     *
     */
    public function newAction(Request $request)
    {
        $page = new Pages();
        $form = $this->createForm('PagesBundle\Form\PagesType', $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('adminPages_show', array('id' => $page->getId()));
        }

        return $this->render('PagesBundle:Administration/pages/layout/new.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pages entity.
     *
     */
    public function showAction(Pages $page)
    {
        $deleteForm = $this->createDeleteForm($page);

        return $this->render('PagesBundle:Administration/pages/layout/show.html.twig', array(
            'page' => $page,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pages entity.
     *
     */
    public function editAction(Request $request, Pages $page)
    {
        $deleteForm = $this->createDeleteForm($page);
        $editForm = $this->createForm('PagesBundle\Form\PagesType', $page);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('adminPages_edit', array('id' => $page->getId()));
        }

        return $this->render('PagesBundle:Administration/pages/layout/edit.html.twig', array(
            'page' => $page,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pages entity.
     *
     */
    public function deleteAction(Request $request, Pages $page)
    {
        $form = $this->createDeleteForm($page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($page);
            $em->flush();
        }

        return $this->redirectToRoute('adminPages_index');
    }

    /**
     * Creates a form to delete a pages entity.
     *
     * @param pages $page The pages entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pages $page)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('adminPages_delete', array('id' => $page->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
