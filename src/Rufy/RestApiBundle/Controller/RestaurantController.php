<?php namespace Rufy\RestApiBundle\Controller; 

use FOS\RestBundle\Controller\FOSRestController,
    FOS\RestBundle\Request\ParamFetcherInterface,
    FOS\RestBundle\Controller\Annotations;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RestaurantController extends FOSRestController
{
    /**
     * Get single Restaurant.
     *
     * @ApiDoc(
     *  resource = true,
     *  description = "Gets a Restaurant for a given id",
     *  output = "Rufy\RestApiBundle\Entity\Restaurant",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Restaurant ID"
     *      }
     *  },
     *
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the reservation is not found"
     *   }
     * )
     *
     * @param int $id Restaurant id
     *
     * @return array
     *
     * @throws NotFoundHttpException when restaurant not exist
     * @throws AccessDeniedException when role is not allowed
     */
    public function getRestaurantAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
            throw new AccessDeniedException();

        $restaurant = $this->getOr404($id);

        return $restaurant;
    }

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
     * Fetch a Restaurant or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return RestaurantInterface
     *
     * @throws NotFoundHttpException
     */
    private function getOr404($id)
    {
        if (!($reservation = $this->get('rufy_api.restaurant.handler')->get($id))) {

            throw new NotFoundHttpException(sprintf('The Restaurant \'%s\' was not found for your Restaurant.', $id));
        }

        return $reservation;
    }
}
