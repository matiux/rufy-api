<?php namespace Rufy\RestApiBundle\Controller; 

use FOS\RestBundle\Request\ParamFetcherInterface,
    FOS\RestBundle\Controller\Annotations;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RestaurantController extends BaseController
{
    /**
     * Get single Restaurant.
     *
     * @ApiDoc(
     *  resource = false,
     *  description = "Gets a Restaurant for a given id",
     *  output = "Rufy\RestApiBundle\Entity\Restaurant",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="The restaurant ID"
     *      }
     *  },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the reservation is not found"
     *   }
     * )
     *
     * @param int $id Restaurant id
     *
     * @return json
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
     *  resource = true,
     *  description     = "Returns a collection of Reservation",
     *  output={
     *      "class"="Rufy\RestApiBundle\Entity\Reservation",
     *      "parser"={
     *          "Rufy\RestApiBundle\Handler\Serializer\RufySerializerHandler"
     *      }
     *  },
     *  requirements={
     *      {
     *          "name"="restaurantId",
     *          "requirement"="\d+",
     *          "dataType"="integer",
     *          "description"="Restaurant ID"
     *      }
     *  },
     *  filters={
     *      {"name"="offset", "dataType"="integer", "requirements"="\d+", "nullable"="true", "default"="0", "description"="Offset from which to start listing reservations."},
     *      {"name"="limit", "dataType"="integer", "requirements"="\d+","nullable"="false", "default"="5", "description"="How many reservations to return."},
     *      {"name"="date", "dataType"="date", "requirements"="\d{4}-\d{2}-\d{2}","nullable"="false", "description"="Reservation date"}
     *  },
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when restaurant not found"
     *  }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", default="0", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many pages to return.")
     * @Annotations\QueryParam(name="date", requirements="\d{4}-\d{2}-\d{2}", description="Reservation date")
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

        $this->prepareFilters($limit, $offset, $filters, $paramFetcher->all());

        $params         = [

            'restaurantId' => $restaurantId
        ];

        $restaurantReservations   = $this->getAllOr404($limit, $offset, $filters, $params);

        return $restaurantReservations;
    }

    /**
     * List all the logged user's restaurants
     *
     * @ApiDoc(
     *  resource = true,
     *  description = "List all the logged user's restaurants",
     *  output="Rufy\RestApiBundle\Entity\Restaurant",
     *  requirements={
     *  },
     *  filters={
     *      {"name"="offset", "dataType"="integer", "nullable"="true", "default"="0", "description"="Offset from which to start listing restaurants."},
     *      {"name"="limit", "dataType"="integer", "nullable"="false", "default"="5", "description"="How many restaurants to return."}
     *  },
     *  statusCodes = {
     *      200 = "Returned when successful",
     *  }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", default="0", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many pages to return.")
     *
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     *
     * @throws AccessDeniedException when role is not allowed
     */
    public function getRestaurantsAction(ParamFetcherInterface $paramFetcher)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
            throw new AccessDeniedException();

        $offset         = $paramFetcher->get('offset');
        $offset         = null == $offset ? 0 : $offset;
        $limit          = $paramFetcher->get('limit');

        $restaurants = $this->container->get('rufy_api.restaurant.handler')->all($limit, $offset);

        return $restaurants;
    }

    /**
     * Fetch a Restaurant reservations or throw an 404 Exception.
     *
     * @param int $limit
     * @param int $offset
     * @param mixed $params
     *
     * @return RestaurantInterface
     *
     * @throws NotFoundHttpException
     */
    private function getAllOr404($limit, $offset, $filters, $params)
    {
        if (!($restaurantReservations = $this->container->get('rufy_api.reservation.handler')->all($limit, $offset, $filters, $params))) {

            throw new NotFoundHttpException(sprintf('The reservations was not found for restaurant  \'%s\'.', $params['restaurantId']));
        }

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

            throw new NotFoundHttpException(sprintf('The Restaurant \'%s\' was not found.', $id));
        }

        return $reservation;
    }
}
