<?php namespace Rufy\RestApiBundle\Controller;

use FOS\RestBundle\Request\ParamFetcherInterface,
    FOS\RestBundle\Controller\Annotations;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Rufy\RestApiBundle\Exception\InvalidFormException;

use Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReservationController extends BaseController
{
    /**
     * Get single Reservation.
     *
     * @ApiDoc(
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

        $reservation = $this->getOr404($id, 'reservation');

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
     * Update existing reservation from the submitted data
     *
     * @ApiDoc(
     *   input = "Rufy\RestApiBundle\Form\ReservationType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @param int $id the reservation id
     *
     * @return FormTypeInterface
     *
     * @throws NotFoundHttpException when Reservation not exist
     */
    public function patchReservationAction($id)
    {
        try {

            $reservation = $this->container->get('rufy_api.reservation.handler')->patch(
                $this->getOr404($id, 'reservation'),
                $this->container->get('request')->request->all()
            );

            return $this->view($reservation, 204);

        } catch(InvalidFormException $exception) {

            return $exception->getForm();
        }
    }
}
