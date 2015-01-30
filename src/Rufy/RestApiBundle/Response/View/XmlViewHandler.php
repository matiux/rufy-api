<?php namespace Rufy\RestApiBundle\Response\View;

use FOS\RestBundle\View\View,
    FOS\RestBundle\View\ViewHandler;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

class XmlViewHandler
{
    /**
     * @param ViewHandler $viewHandler
     * @param View $view
     * @param Request $request
     * @param string $format
     *
     * @return Response
     */
    public function createResponse(ViewHandler $handler, View $view, Request $request, $format)
    {

        $content = "<?xml version=\"1.0\" ?>\n";
        $content .= "<daimplementare>\n";
        $content .= "</daimplementare>";

        return new Response($content, 200, $view->getHeaders());
    }
}
