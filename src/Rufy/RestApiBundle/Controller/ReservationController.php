<?php namespace Rufy\RestApiBundle\Controller; 

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Rufy\RestApiBundle\Model\ReservationInterface;

class ReservationController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Get single Reservation.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Reservation for a given id",
     *   output = "Rufy\RestApiBundle\Entity\Reservation",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the page is not found"
     *   }
     * )
     *
     * @param int     $id      the page id
     *
     * @return array
     *
     * @throws NotFoundHttpException when reservation not exist
     */
    public function getAction($id)
    {
        $reservation = $this->getOr404($id);

        return $reservation;
    }

    public function cgetAction()
    {
        $reservation = $this->getDoctrine()->getRepository('\Rufy\RestApiBundle\Entity\Reservation')->findAll();
        //$reservation = $this->get('doctrine.orm.default_entity_manager')->getRepository('\Rufy\RestApiBundle\Entity\Reservation')->find($id);

        return new Response('<html><body>Numero: '.rand(5, 10).'</body></html>');
    }


    /**
     * Fetch a Page or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return ReservationInterface
     *
     * @throws NotFoundHttpException
     */
    private function getOr404($id)
    {
        if (!($reservation = $this->get('rufy_api.reservation.handler')->get($id))) {

            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $id));
        }

        return $reservation;
    }
}
