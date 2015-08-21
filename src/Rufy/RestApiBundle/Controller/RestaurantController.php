<?php namespace Rufy\RestApiBundle\Controller; 

use FOS\RestBundle\Controller\Annotations\View,
    FOS\RestBundle\Request\ParamFetcherInterface,
    FOS\RestBundle\Controller\Annotations;

use Rufy\RestApiBundle\Exception\InvalidFormException,
    Rufy\RestApiBundle\Model\RestaurantInterface,
    Rufy\RestApiBundle\Model\AreaInterface;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RestaurantController extends BaseController
{
    /**
     * List all reservations by a given id restaurant
     *
     * @param int $restaurantId
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @Annotations\QueryParam(name="offset", strict=true, allowBlank=true, nullable=true, requirements="\d+", default="0", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", strict=true, allowBlank=true, nullable=true, requirements="\d+", default="0", description="How many reservations to return per page.")
     * @Annotations\QueryParam(name="date", strict=true, allowBlank=true, nullable=true, requirements="\d{4}-\d{2}-\d{2}", description="Reservation date")
     * @Annotations\QueryParam(name="status", strict=true, allowBlank=true, nullable=true, requirements="[012,]*", description="Reservation status")
     * @Annotations\QueryParam(name="customer_name", strict=true, allowBlank=true, nullable=true, requirements="\w+", description="Customer name")
     * @Annotations\QueryParam(name="customer_phone", strict=true, allowBlank=true, nullable=true, requirements="\w+", description="Customer phone")
     * @Annotations\QueryParam(name="customer_email", strict=true, allowBlank=true, nullable=true, requirements="\w+", description="Customer email")
     *
     * TODO
     * @Annotations\QueryParam(name="date_range", strict=true, allowBlank=true, nullable=true, requirements="\d{4}-\d{2}-\d{2}|\d{4}-\d{2}-\d{2}", description="Date range reservation")
     * @Annotations\QueryParam(name="month", strict=true, allowBlank=true, nullable=true, requirements="\d{2}", description="Month reservation")
     *
     * @return array
     * @View()
     */
    public function getRestaurantReservationsAction($restaurantId, ParamFetcherInterface $paramFetcher, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_READER', null, 'Non si può accedere a questa risorsa!');

        $this->prepareFilters($limit, $offset, $filters, $paramFetcher);

        $params         = [

            'restaurantId' => $restaurantId
        ];

        $restaurantReservations   = $this->getAllOr404($limit, $offset, $filters, $params, 'reservation');

        return $restaurantReservations;
    }

    /**
     * List all customers by a given id restaurant
     *
     * @Annotations\QueryParam(name="offset", strict=true, allowBlank=true, nullable=true, requirements="\d+", default="0", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", strict=true, allowBlank=true, nullable=true, requirements="\d+", default="0", description="How many customers to return per page.")
     *
     * @param int $restaurantId Restaurant id
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     * @View()
     *
     */
    public function getRestaurantCustomersAction($restaurantId, ParamFetcherInterface $paramFetcher)
    {
        $this->denyAccessUnlessGranted('ROLE_READER', null, 'Non si può accedere a questa risorsa!');

        $this->prepareFilters($limit, $offset, $filters, $paramFetcher);

        $params         = [

            'restaurantId' => $restaurantId
        ];

        $restaurantCustomers   = $this->getAllOr404($limit, $offset, $filters, $params, 'customer');

        return $restaurantCustomers;
    }

    /**
     * List all areas by a given id restaurant
     *
     * @Annotations\QueryParam(name="offset", strict=true, allowBlank=true, nullable=true, requirements="\d+", default="0", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", strict=true, allowBlank=true, nullable=true, requirements="\d+", default="0", description="How many areas to return per page.")
     *
     * @param int $restaurantId Restaurant id
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     * @View()
     */
    public function getRestaurantAreasAction($restaurantId, ParamFetcherInterface $paramFetcher)
    {
        $this->denyAccessUnlessGranted('ROLE_READER', null, 'Non si può accedere a questa risorsa!');

        $this->prepareFilters($limit, $offset, $filters, $paramFetcher);

        $params         = [

            'restaurantId' => $restaurantId
        ];

        $restaurantAreas   = $this->getAllOr404($limit, $offset, $filters, $params, 'area');

        return $restaurantAreas;
    }

    /**
     * List all the logged user's restaurants
     *
     * @Annotations\QueryParam(name="offset", strict=true, allowBlank=true, nullable=true, requirements="\d+", default="0", nullable=true, description="Offset from which to start listing pages.")
     * @Annotations\QueryParam(name="limit", strict=true, allowBlank=true, nullable=true, requirements="\d+", default="0", description="How many reservations to return per page.")
     *
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     * @View()
     */
    public function getRestaurantsAction(ParamFetcherInterface $paramFetcher)
    {
        $this->denyAccessUnlessGranted('ROLE_READER', null, 'Non si può accedere a questa risorsa!');

        $this->prepareFilters($limit, $offset, $filters, $paramFetcher);

        $restaurants = $this->container->get('rufy_api.restaurant.handler')->all($limit, $offset);

        return $restaurants;
    }

    /**
     * Create a Restaurant
     *
     * @param Request $request
     * @View()
     * @return array
     */
    public function postRestaurantAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Non si può accedere a questa risorsa!');

        try {

            /**
             * TODO
             * Da testare
             */
            //$this->prepareRequest($request);

            $restaurant = $this->get('rufy_api.restaurant.handler')->post($request);

            return $this->view($restaurant, 201);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing restaurant
     *
     * @param int $id the restaurant id
     * @param Request $request
     *
     * @View()
     *
     * @return array
     */
    public function patchRestaurantAction($id, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Non si può accedere a questa risorsa!');

        try {

            $restaurant = $this->patchAction('restaurant', $this->getOr404($id, 'restaurant'), $request);

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
     * @return \FOS\RestBundle\View\View
     */
    public function deleteRestaurantAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Non si può accedere a questa risorsa!');

        $restaurant = $this->getOr404($id, 'restaurant');

        $this->container->get('rufy_api.restaurant.handler')->delete($restaurant);

        return $this->view($restaurant, 204);
    }

    /**
     * Get single Restaurant.
     *
     * @param int $id - Restaurant id
     *
     * @return array
     * @View()
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
