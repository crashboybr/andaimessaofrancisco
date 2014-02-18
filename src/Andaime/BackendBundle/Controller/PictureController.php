<?php

namespace Andaime\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Andaime\BackendBundle\Entity\Picture;
use Andaime\BackendBundle\Form\PictureType;

/**
 * Picture controller.
 *
 */
class PictureController extends Controller
{

    /**
     * Lists all Picture entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AndaimeBackendBundle:Picture')->findAll();

        return $this->render('AndaimeBackendBundle:Picture:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Picture entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Picture();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fotos_show', array('id' => $entity->getId())));
        }

        return $this->render('AndaimeBackendBundle:Picture:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Picture entity.
    *
    * @param Picture $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Picture $entity)
    {
        $form = $this->createForm(new PictureType(), $entity, array(
            'action' => $this->generateUrl('fotos_create'),
            'method' => 'POST',
            'csrf_protection' => false
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Picture entity.
     *
     */
    public function newAction()
    {
        $entity = new Picture();
        $form   = $this->createCreateForm($entity);

        return $this->render('AndaimeBackendBundle:Picture:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Picture entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AndaimeBackendBundle:Picture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Picture entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AndaimeBackendBundle:Picture:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Picture entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AndaimeBackendBundle:Picture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Picture entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AndaimeBackendBundle:Picture:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Picture entity.
    *
    * @param Picture $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Picture $entity)
    {
        $form = $this->createForm(new PictureType(), $entity, array(
            'action' => $this->generateUrl('fotos_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'csrf_protection' => false
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Picture entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AndaimeBackendBundle:Picture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Picture entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('fotos_edit', array('id' => $id)));
        }

        return $this->render('AndaimeBackendBundle:Picture:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Picture entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AndaimeBackendBundle:Picture')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Picture entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('fotos'));
    }

    /**
     * Creates a form to delete a Picture entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fotos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
