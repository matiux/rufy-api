<?php namespace Rufy\RestApiBundle\Controller; 

use FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\Controller\Annotations,
    FOS\RestBundle\Controller\Annotations\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Rufy\RestApiBundle\Exception\InvalidFormException;

use Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReservationController extends FOSRestController
{
    /**
     * Get single Reservation.
     *
     * @ApiDoc(
     *  resource = false,
     *  description = "Gets a Reservation for a given id",
     *  output = {
     *      "class" = "Rufy\RestApiBundle\Entity\Reservation",
     *      "param" = {
     *          {
     *               "name" = "altro"
     *          }
     *      },
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *          "Nelmio\ApiDocBundle\Parser\ValidationParser"
     *      }
     *  },
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "description"="Reservation ID"
     *      }
     *  },
     *
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the reservation is not found"
     *   }
     * )
     *
     * @param int $id Reservation id
     *
     * @return json
     *
     * @throws NotFoundHttpException when reservation not exist
     * @throws AccessDeniedException when role is not allowed
     */
    public function getReservationAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
            throw new AccessDeniedException();

        $reservation = $this->getOr404($id);

        return $reservation;
    }

    /**
     * Create a Reservation from the sended data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new reservation from the sended data.",
     *   input = "Rufy\RestApiBundle\Form\ReservationType",
     *   output = {
     *      "class" = "Rufy\RestApiBundle\Entity\Reservation",
     *   },
     *   statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when the data is invalid or non-existent",
     *     403 = "Returned when relationships are not allowed"
     *   }
     * )
     *
     * @throws AccessDeniedException if user is not logged in
     */
    public function postReservationAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
            throw new AccessDeniedException();

        try {

            $reservation = $this->get('rufy_api.reservation.handler')->post($this->container->get('request')->request->all());

            return $this->view($reservation, 201);

            //return $this->handleView($view);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Fetch a Reservation or throw an 404 Exception.
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
