<?php namespace Rufy\RestApiBundle\Controller; 

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends FOSRestController implements ClassResourceInterface
{
    /**
     * // [GET] /resource/{id}
     *
     * @param $id
     * @return Response
     */
    public function getAction($id)
    {
        $reservation = $this->getDoctrine()->getRepository('\Rufy\RestApiBundle\Entity\Reservation')->find($id);
        //$reservation = $this->get('doctrine.orm.default_entity_manager')->getRepository('\Rufy\RestApiBundle\Entity\Reservation')->find($id);

        return new Response('<html><body>Numero: '.rand(1, 10).'</body></html>');
    }

    /**
     * // [GET] /resource/{id}
     *
     * @return Response
     */
    public function cgetAction()
    {
        $reservation = $this->getDoctrine()->getRepository('\Rufy\RestApiBundle\Entity\Reservation')->findAll();
        //$reservation = $this->get('doctrine.orm.default_entity_manager')->getRepository('\Rufy\RestApiBundle\Entity\Reservation')->find($id);

        return new Response('<html><body>Numero: '.rand(5, 10).'</body></html>');
    }
}
