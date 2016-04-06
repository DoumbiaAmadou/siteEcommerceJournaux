<?php

namespace journalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use journalBundle\Entity\Categories;
use journalBundle\Form\CategoriesType;

/**
 * Categorie controller.
 *
 */
class CategoriesAdminController extends Controller
{
    /**
     * Lists all Categorie entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('journalBundle:Categories')->findAll();
        
        $categoriefind = $this->get('knp_paginator')->paginate($categories , $this->get('request')->query->get('page', 1), 6);

        return $this->render('journalBundle:Administration/categories/index.html.twig', array(
            'categories' => $categoriefind,
        ));
    }

    /**
     * Creates a new Categorie entity.
     *
     */
    public function newAction(Request $request)
    {
        $categorie = new Categories();
        $form = $this->createForm('journalBundle\Form\CategoriesType', $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('AdminCategorie_show', array('id' => $categorie->getId()));
        }
        
       
     
        return $this->render('journalBundle:Administration/categories/new.html.twig', array(
            'categorie' =>$categorie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Categorie entity.
     *
     */
    public function showAction(Categories $categorie)
    {
        $deleteForm = $this->createDeleteForm($categorie);

        return $this->render('journalBundle:Administration/categories/show.html.twig', array(
            'categorie' => $categorie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Categorie entity.
     *
     */
    public function editAction(Request $request, Categories $categorie)
    {
        $deleteForm = $this->createDeleteForm($categorie);
        $editForm = $this->createForm('journalBundle\Form\CategoriesType', $categorie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('AdminCategorie_edit', array('id' => $categorie->getId()));
        }

        return $this->render('journalBundle:Administration/categories/edit.html.twig', array(
            'categorie' => $categorie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Categorie entity.
     *
     */
    public function deleteAction(Request $request, Categories $categorie)
    {
        $form = $this->createDeleteForm($categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorie);
            $em->flush();
        }

        return $this->redirectToRoute('AdminCategorie_index');
    }

    /**
     * Creates a form to delete a Categorie entity.
     *
     * @param Categorie $categorie The Categorie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Categories $categorie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('AdminCategorie_delete', array('id' => $categorie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
