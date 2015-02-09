<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RestaurantHandler extends AbstractEntityHandler implements HandlerInterface
{
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
        $restaurant = $this->repository->findCustom($id);

        if (false === $this->authChecker->isGranted('VIEW', $restaurant)) {
            throw new AccessDeniedException('Accesso non autorizzato!');
        }

        return $restaurant;
    }

    /**
     * Get a list of Restaurants.
     *
     * @param int $limit the limit of the result
     * @param int $offset starting from the offset
     * @param array $params filter params
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0, $params = array())
    {
        $params['userId']   = $this->user->getId();

        $restaurants        = $this->repository->findRestaurants($limit, $offset, $params);

        return $restaurants;
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
     * Partially update a Entity.
     *
     * @api
     *
     * @param $entity
     * @param array           $parameters
     *
     * @return Entity
     */
    public function patch($entity, array $parameters)
    {

    }
}
