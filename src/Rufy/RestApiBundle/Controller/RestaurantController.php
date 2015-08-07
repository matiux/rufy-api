<?php namespace Rufy\RestApiBundle\Controller; 

use FOS\RestBundle\Request\ParamFetcherInterface,
    FOS\RestBundle\Controller\Annotations;

use Rufy\RestApiBundle\Exception\InvalidFormException,
    Rufy\RestApiBundle\Model\RestaurantInterface,
    Rufy\RestApiBundle\Model\AreaInterface;

use Symfony\Component\Config\Definition\Exception\Exception,
    Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RestaurantController extends BaseController
{
    /**
     * List all reservations by a given id restaurant
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", default="0", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="0", description="How many reservations to return per page.")
     * @Annotations\QueryParam(name="date", requirements="\d{4}-\d{2}-\d{2}", description="Reservation date")
     * @Annotations\QueryParam(name="status", requirements="[012,]*", description="Reservation status")
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
     * @Annotations\QueryParam(name="offset", requirements="\d+", default="0", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="0", description="How many customers to return per page.")
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
     * @Annotations\QueryParam(name="offset", requirements="\d+", default="0", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="0", description="How many areas to return per page.")
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
     * @Annotations\QueryParam(name="offset", requirements="\d+", default="0", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="0", description="How many reservations to return per page.")
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
     * Update existing restaurant
     *
     * @param int $id the restaurant id
     *
     * @return FormTypeInterface
     *
     * @throws NotFoundHttpException when Restaurant doesn't exist
     */
    public function patchRestaurantAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Non si può accedere a questa risorsa!');

        try {

            $restaurant = $this->patchAction('restaurant', $this->getOr404($id, 'restaurant'));

            return $this->view($restaurant, 204);

        } catch(InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Delete existing restaurant
     *
     * @param int $id Restaurant id
     *
     *
     * @throws NotFoundHttpException when restaurant doesn't exist
     * @throws AccessDeniedException when role is not allowed
     */
    public function deleteRestaurantAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Non si può accedere a questa risorsa!');

        $restaurant = $this->getOr404($id, 'restaurant');

        $this->container->get('rufy_api.restaurant.handler')->delete($restaurant);
    }

    /**
     * Get single Restaurant.
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
     * Fetch the entities or throw an 404 Exception.
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

            //throw new NotFoundHttpException(sprintf("The {$type}s was not found for restaurant  '%s'", $params['restaurantId']));
            return [];
        }

        return $entities;
    }
}
