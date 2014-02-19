<?php

namespace Andaime\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Andaime\BackendBundle\Entity\Manual;
use Andaime\BackendBundle\Form\ManualType;

/**
 * Manual controller.
 *
 */
class ManualController extends Controller
{

    /**
     * Lists all Manual entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AndaimeBackendBundle:Manual')->findAll();

        return $this->render('AndaimeBackendBundle:Manual:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Manual entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Manual();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('manual_show', array('id' => $entity->getId())));
        }

        return $this->render('AndaimeBackendBundle:Manual:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Manual entity.
    *
    * @param Manual $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Manual $entity)
    {
        $form = $this->createForm(new ManualType(), $entity, array(
            'action' => $this->generateUrl('manual_create'),
            'method' => 'POST',
            'csrf_protection' => false
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Manual entity.
     *
     */
    public function newAction()
    {
        $entity = new Manual();
        $form   = $this->createCreateForm($entity);

        return $this->render('AndaimeBackendBundle:Manual:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Manual entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AndaimeBackendBundle:Manual')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Manual entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AndaimeBackendBundle:Manual:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Manual entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AndaimeBackendBundle:Manual')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Manual entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AndaimeBackendBundle:Manual:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Manual entity.
    *
    * @param Manual $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Manual $entity)
    {
        $form = $this->createForm(new ManualType(), $entity, array(
            'action' => $this->generateUrl('manual_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'csrf_protection' => false
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Manual entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AndaimeBackendBundle:Manual')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Manual entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('manual_edit', array('id' => $id)));
        }

        return $this->render('AndaimeBackendBundle:Manual:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Manual entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AndaimeBackendBundle:Manual')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Manual entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('manual'));
    }

    /**
     * Creates a form to delete a Manual entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(null,array('csrf_protection' => false))
            ->setAction($this->generateUrl('manual_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
