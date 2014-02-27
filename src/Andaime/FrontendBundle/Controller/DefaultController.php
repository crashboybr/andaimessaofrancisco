<?php

namespace Andaime\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Andaime\FrontendBundle\Form\Type\ContactType;
use Andaime\BackendBundle\Entity\Product;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pics = $em->getRepository('AndaimeBackendBundle:Picture')
            ->findAll();

        return $this->render('AndaimeFrontendBundle:Default:index.html.twig', array('pics' => $pics));
    }

    public function productAction()
    {
    	$em = $this->getDoctrine()->getManager();


        $products = $em->getRepository('AndaimeBackendBundle:Product')
            ->findAll();

        return $this->render('AndaimeFrontendBundle:Default:product.html.twig', array('products' => $products));
    }

    public function viewProductAction(Product $product)
    {
        //var_dump($product);exit;
        $em = $this->getDoctrine()->getManager();


        $products = $em->getRepository('AndaimeBackendBundle:Product')
            ->findAll();

        return $this->render('AndaimeFrontendBundle:Default:viewProduct.html.twig', array('product' => $product, 'products' => $products));
    }

    public function contactAction()
    {   
        $request = $this->getRequest();
        $form = $this->createForm(new ContactType(), null, array('csrf_protection' => false));

    if ($request->isMethod('POST')) {
        $form->bind($request);
        
        if ($form->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject($form->get('subject')->getData())
                ->setFrom($form->get('email')->getData())
                ->setTo('contato@andaimessaofrancisco.com.br')
                ->setBody(
                    $this->renderView(
                        'AndaimeFrontendBundle:Mail:contact.html.twig',
                        array(
                            'ip' => $request->getClientIp(),
                            'name' => $form->get('name')->getData(),
                            'message' => $form->get('message')->getData(),
                            'email' => $form->get('email')->getData(),
                            'subject' => $form->get('subject')->getData()
                        )
                    )
                );

                        //exit;

            $this->get('mailer')->send($message);

            
            $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Seu contato foi enviado!'
                );

            return $this->redirect($this->generateUrl('andaime_frontend_contact'));
        }
    }

        return $this->render('AndaimeFrontendBundle:Default:contact.html.twig', array(
        'form' => $form->createView()
        ));
    }

    public function sendContactAction()
    {
        return $this->render('AndaimeFrontendBundle:Default:contact.html.twig');
    }

    public function aboutAction()
    {
        return $this->render('AndaimeFrontendBundle:Default:about.html.twig');
    }

    public function manualAction()
    {
        $em = $this->getDoctrine()->getManager();


        $manuals = $em->getRepository('AndaimeBackendBundle:Manual')
            ->findAll();

        return $this->render('AndaimeFrontendBundle:Default:manual.html.twig', array('products' => $manuals));
        
    }

    public function mapAction()
    {
        return $this->render('AndaimeFrontendBundle:Default:map.html.twig');
    }
}
