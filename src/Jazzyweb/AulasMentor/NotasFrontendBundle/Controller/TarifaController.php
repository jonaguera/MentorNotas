<?php

namespace Jazzyweb\AulasMentor\NotasFrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Jazzyweb\AulasMentor\NotasFrontendBundle\Entity\Tarifa;
use Jazzyweb\AulasMentor\NotasFrontendBundle\Form\TarifaType;

/**
 * Tarifa controller.
 *
 */
class TarifaController extends Controller
{
    /**
     * Lists all Tarifa entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('JAMNotasFrontendBundle:Tarifa')->findAll();

        return $this->render('JAMNotasFrontendBundle:Tarifa:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Tarifa entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JAMNotasFrontendBundle:Tarifa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tarifa entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JAMNotasFrontendBundle:Tarifa:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Tarifa entity.
     *
     */
    public function newAction()
    {
        $entity = new Tarifa();
        $form   = $this->createForm(new TarifaType(), $entity);

        return $this->render('JAMNotasFrontendBundle:Tarifa:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Tarifa entity.
     *
     */
    public function createAction()
    {
        $entity  = new Tarifa();
        $request = $this->getRequest();
        $form    = $this->createForm(new TarifaType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tarifa_show', array('id' => $entity->getId())));
            
        }

        return $this->render('JAMNotasFrontendBundle:Tarifa:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Tarifa entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JAMNotasFrontendBundle:Tarifa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tarifa entity.');
        }

        $editForm = $this->createForm(new TarifaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('JAMNotasFrontendBundle:Tarifa:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Tarifa entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('JAMNotasFrontendBundle:Tarifa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tarifa entity.');
        }

        $editForm   = $this->createForm(new TarifaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tarifa_edit', array('id' => $id)));
        }

        return $this->render('JAMNotasFrontendBundle:Tarifa:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tarifa entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JAMNotasFrontendBundle:Tarifa')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tarifa entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tarifa'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
