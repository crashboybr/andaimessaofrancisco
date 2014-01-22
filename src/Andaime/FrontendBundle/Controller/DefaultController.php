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
}
