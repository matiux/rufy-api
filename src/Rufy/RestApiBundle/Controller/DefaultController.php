<?php

namespace Rufy\RestApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RufyRestApiBundle:Default:index.html.twig', array('name' => $name));
    }
}
