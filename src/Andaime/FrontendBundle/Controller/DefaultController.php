<?php

namespace Andaime\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AndaimeFrontendBundle:Default:index.html.twig', array('name' => 'oi'));
    }

    public function productAction()
    {
    	$em = $this->getDoctrine()->getManager();


        $products = $em->getRepository('AndaimeBackendBundle:Product')
            ->findAll();

        return $this->render('AndaimeFrontendBundle:Default:product.html.twig', array('products' => $products));
    }

    public function contactAction()
    {
        return $this->render('AndaimeFrontendBundle:Default:contact.html.twig');
    }

    public function aboutAction()
    {
        return $this->render('AndaimeFrontendBundle:Default:about.html.twig');
    }

    public function serviceAction()
    {
        return $this->render('AndaimeFrontendBundle:Default:service.html.twig');
    }
}
