<?php namespace Rufy\RestApiBundle\Response\View;

use FOS\RestBundle\View\View,
    FOS\RestBundle\View\ViewHandler;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

class JsonViewHandler
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
        //difinizione della logica

        $reservation = $view->getData();
        $customer = $reservation->getCustomer()->getName();

        $data = json_encode(['ciao' => 'Matteo']);

        return new Response($data, 200, $view->getHeaders());
    }
}
