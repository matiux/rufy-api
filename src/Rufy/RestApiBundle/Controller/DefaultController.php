<?php namespace Rufy\RestApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $rendered   = $this->renderView('RufyRestApiBundle:Default:index.html.twig');

        $response   = new Response($rendered);

        $response->headers->set('Content-Type', 'text/html');

        return $response;
    }
}
