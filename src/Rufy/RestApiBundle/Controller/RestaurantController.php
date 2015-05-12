<?php namespace Rufy\RestApiBundle\Controller; 

use FOS\RestBundle\Request\ParamFetcherInterface,
    FOS\RestBundle\Controller\Annotations;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Rufy\RestApiBundle\Exception\InvalidFormException,
    Rufy\RestApiBundle\Model\RestaurantInterface,
    Rufy\RestApiBundle\Model\AreaInterface;

use Symfony\Component\Config\Definition\Exception\Exception,
    Symfony\Component\Security\Core\Exception\AccessDeniedException,
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
     *     403 = "Returned when you try to get a restaurant of another user",
     *     404 = "Returned when the restaurant has not been found"
     *   }
     * )
     *
     * @param int $id - Restaurant id
     *
     * @return json
     *
     * @throws NotFoundHttpException when restaurant doesn't exist
     * @throws AccessDeniedException when role is not allowed
     */
    public function getRestaurantAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_READER', null, 'Non si può accedere a questa risorsa!');

        $restaurant = $this->getOr404($id, 'restaurant');

        return $restaurant;
    }

    /**
     * List all reservations by a given id restaurant
     *
     * @ApiDoc(
     *  resource = false,
     *  description = "Returns a collection of Reservation",
     *  output="Rufy\RestApiBundle\Entity\Reservation",
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
     *      {"name"="date", "dataType"="date", "requirements"="\d{4}-\d{2}-\d{2}","nullable"="false", "description"="Reservation date"},
     *      {"name"="status", "dataType"="integer", "requirements"="[012]","nullable"="false", "description"="Reservation status"}
     *  },
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     403 = "Returned when you try to get the reservations of another restaurant",
     *     404 = "Returned when no reservation has been found"
     *  }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", default="0", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many reservations to return per page.")
     * @Annotations\QueryParam(name="date", requirements="\d{4}-\d{2}-\d{2}", description="Reservation date")
     * @Annotations\QueryParam(name="status", requirements="[012]", description="Reservation status")
     *
     * @param int $restaurantId Restaurant id
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return json
     *
     * @throws AccessDeniedException when role is not allowed
     */
    public function getRestaurantReservationsAction($restaurantId, ParamFetcherInterface $paramFetcher)
    {
        $this->denyAccessUnlessGranted('ROLE_READER', null, 'Non si può accedere a questa risorsa!');

        $this->prepareFilters($limit, $offset, $filters, $paramFetcher->all());

        $params         = [

            'restaurantId' => $restaurantId
        ];

        $restaurantReservations   = $this->getAllOr404($limit, $offset, $filters, $params, 'reservation');

        return $restaurantReservations;
    }

    /**
     * List all customers by a given id restaurant
     *
     * @ApiDoc(
     *  resource = false,
     *  description = "Returns a collection of Customer",
     *  output="Rufy\RestApiBundle\Entity\Customer",
     *  requirements={
     *      {
     *          "name"="restaurantId",
     *          "requirement"="\d+",
     *          "dataType"="integer",
     *          "description"="Restaurant ID"
     *      }
     *  },
     *  filters={
     *      {"name"="offset", "dataType"="integer", "requirements"="\d+", "nullable"="true", "default"="0", "description"="Offset from which to start listing customers."},
     *      {"name"="limit", "dataType"="integer", "requirements"="\d+","nullable"="false", "default"="5", "description"="How many customers to return."},
     *  },
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     403 = "Returned when you try to get the customers of another restaurants",
     *     404 = "Returned when no restaurant has been found"
     *  }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", default="0", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many customers to return per page.")
     *
     * @param int $restaurantId Restaurant id
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return json
     *
     * @throws AccessDeniedException when role is not allowed
     */
    public function getRestaurantCustomersAction($restaurantId, ParamFetcherInterface $paramFetcher)
    {
        $this->denyAccessUnlessGranted('ROLE_READER', null, 'Non si può accedere a questa risorsa!');

        $this->prepareFilters($limit, $offset, $filters, $paramFetcher->all());

        $params         = [

            'restaurantId' => $restaurantId
        ];

        $restaurantCustomers   = $this->getAllOr404($limit, $offset, $filters, $params, 'customer');

        return $restaurantCustomers;
    }

    /**
     * List all areas by a given id restaurant
     *
     * @ApiDoc(
     *  resource = false,
     *  description="Returns a collection of Area",
     *  output="Rufy\RestApiBundle\Entity\Area",
     *  requirements={
     *      {
     *          "name"="restaurantId",
     *          "requirement"="\d+",
     *          "dataType"="integer",
     *          "description"="Restaurant ID"
     *      }
     *  },
     *  filters={
     *      {"name"="offset", "dataType"="integer", "requirements"="\d+", "nullable"="true", "default"="0", "description"="Offset from which to start listing areas."},
     *      {"name"="limit", "dataType"="integer", "requirements"="\d+","nullable"="false", "default"="5", "description"="How many areas to return."},
     *  },
     *  statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when no area has been found"
     *  }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", default="0", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many areas to return per page.")
     *
     * @param int $restaurantId Restaurant id
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     *
     * @throws AccessDeniedException when role is not allowed
     */
    public function getRestaurantAreasAction($restaurantId, ParamFetcherInterface $paramFetcher)
    {
        $this->denyAccessUnlessGranted('ROLE_READER', null, 'Non si può accedere a questa risorsa!');

        $this->prepareFilters($limit, $offset, $filters, $paramFetcher->all());

        $params         = [

            'restaurantId' => $restaurantId
        ];

        $restaurantAreas   = $this->getAllOr404($limit, $offset, $filters, $params, 'area');

        return $restaurantAreas;
    }

    /**
     * List all the logged user's restaurants
     *
     * @ApiDoc(
     *  resource = false,
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
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many reservations to return per page.")
     *
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     *
     * @throws AccessDeniedException when role is not allowed
     */
    public function getRestaurantsAction(ParamFetcherInterface $paramFetcher)
    {
        $this->denyAccessUnlessGranted('ROLE_READER', null, 'Non si può accedere a questa risorsa!');

        $this->prepareFilters($limit, $offset, $filters, $paramFetcher->all());

        $restaurants = $this->container->get('rufy_api.restaurant.handler')->all($limit, $offset);

        return $restaurants;
    }

    /**
     * Create a Restaurant
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new Restaurant.",
     *   input = "Rufy\RestApiBundle\Form\RestaurantType",
     *   output = "Rufy\RestApiBundle\Entity\Restaurant",
     *   statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when the data is invalid or non-existent",
     *     403 = "Returned when relationships are not allowed"
     *   }
     * )
     *
     * @throws AccessDeniedException if user is not logged in
     */
    public function postRestaurantAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Non si può accedere a questa risorsa!');

        try {

            $params         = $this->container->get('request')->request->all();
            $restaurant     = $this->get('rufy_api.restaurant.handler')->post($params);

            return $this->view($restaurant, 201);

            //return $this->handleView($view);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Fetch a entioties or throw an 404 Exception.
     *
     * @param int $limit
     * @param int $offset
     * @param mixed $filters
     * @param mixed $params
     * @param string $type
     *
     * @return RestaurantInterface|AreaInterface
     *
     * @throws NotFoundHttpException
     */
    private function getAllOr404($limit, $offset, $filters, $params, $type)
    {
        if (!($entities = $this->container->get("rufy_api.$type.handler")->all($limit, $offset, $filters, $params))) {

            throw new NotFoundHttpException(sprintf("The {$type}s was not found for restaurant  '%s'", $params['restaurantId']));
        }

        return $entities;
    }
}
