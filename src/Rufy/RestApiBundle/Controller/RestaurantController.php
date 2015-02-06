<?php namespace Rufy\RestApiBundle\Controller; 

use FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\Request\ParamFetcherInterface,
    FOS\RestBundle\Controller\Annotations;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class RestaurantController extends FOSRestController
{
    /**
     * List all reservations by a given restaurant
     *
     * @ApiDoc(
     *  resource        = true,
     *  description     = "List all reservations by a given restaurant",
     *  requirements={
     *      {
     *          "name"="restaurantId",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Restaurant ID"
     *      }
     *  },
     *
     *   statusCodes = {
     *     200 = "Returned when successful",
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing reservations.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many reservations to return.")
     *
     * @param int $restaurantId Restaurant id
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     *
     * @throws AccessDeniedException when role is not allowed
     */
    public function getRestaurantReservationsAction($restaurantId, ParamFetcherInterface $paramFetcher)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
            throw new AccessDeniedException();

        $offset         = $paramFetcher->get('offset');
        $offset         = null == $offset ? 0 : $offset;
        $limit          = $paramFetcher->get('limit');

        $restaurantReservations   = $this->container->get('rufy_api.reservation.handler')->all($restaurantId, $limit, $offset);

        return $restaurantReservations;
    }

    /**
     * TODO
     * Fetch a Restaurant or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return ReservationInterface
     *
     * @throws NotFoundHttpException
     */
    private function getOr404($id)
    {
        /**
         *
         */
        if (!($reservation = $this->get('rufy_api.restaurant.handler')->get($id))) {

            throw new NotFoundHttpException(sprintf('The Restaurant \'%s\' was not found for your Restaurant.', $id));
        }

        return $reservation;
    }
}
