<?php

namespace Rufy\RestApiDevBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RufyRestApiDevBundle:Default:index.html.twig', array('name' => $name));
    }
}
