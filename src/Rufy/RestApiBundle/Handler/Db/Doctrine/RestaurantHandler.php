<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine; 


class RestaurantHandler extends AbstractEntityHandler implements HandlerInterface
{

    public function setEntityClass($entityClass)
    {

    }

    /**
     * Get a Entity given the identifier
     *
     * @api
     *
     * @param int $id
     *
     * @return Entity
     */
    public function get($id)
    {

    }

    /**
     * Get a list of Reservations.
     *
     * @param int $restaurantId the restaurant's id
     * @param int $limit the limit of the result
     * @param int $offset starting from the offset
     * @param array $params filter params
     *
     * @return array
     */
    public function all($restaurantId, $limit = 5, $offset = 0, $params = array())
    {

    }

    /**
     * Post Entity, creates a new Entity.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return Entity
     */
    public function post(array $parameters)
    {

    }

    /**
     * Edit a Entity.
     *
     * @api
     *
     * @param $entity
     * @param array $parameters
     *
     * @return Entity
     */
    public function put($entity, array $parameters)
    {

    }

    /**
     * Partially update a Reservation.
     *
     * @api
     *
     * @param $entity
     * @param array $parameters
     *
     * @return Entity
     */
    public function patch($entity, array $parameters)
    {

    }
}
