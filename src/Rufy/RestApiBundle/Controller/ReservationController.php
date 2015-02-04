<?php namespace Rufy\RestApiBundle\Controller; 

use FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\Routing\ClassResourceInterface,
    FOS\RestBundle\Controller\Annotations;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReservationController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Get single Reservation.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Reservation for a given id",
     *   output = "Rufy\RestApiBundle\Entity\Reservation",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Reservation ID"
     *      }
     *  },
     *   parameters={
     *      {"name"="id", "dataType"="integer", "required"=true, "format"="", "description"="Reservation ID"}
     *   },
     *
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the reservation is not found"
     *   }
     * )
     *
     * @param int $id Reservation id
     *
     * @return array
     *
     * @throws NotFoundHttpException when reservation not exist
     * @throws AccessDeniedException when role is not allowed
     */
    public function getAction($id)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'))
            throw new AccessDeniedException();

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

            throw new NotFoundHttpException(sprintf('The Reservation \'%s\' was not found for your Restaurant.', $id));
        }

        return $reservation;
    }
}
