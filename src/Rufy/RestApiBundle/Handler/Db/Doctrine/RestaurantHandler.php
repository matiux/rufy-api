<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RestaurantHandler extends AbstractEntityHandler implements EntityHandlerInterface
{
    /**
     * {@inheritdoc }
     */
    public function get($id)
    {
        $restaurant = $this->repository->findCustom($id);

        if ($restaurant && false === $this->authChecker->isGranted('VIEW', $restaurant)) {
            throw new AccessDeniedException('Accesso non autorizzato!');
        }

        return $restaurant;
    }

    /**
     * {@inheritdoc }
     */
    public function all($limit = 5, $offset = 0, $filters = array(), $params = array())
    {
        $params['userId'] = $this->user->getId();

        $restaurants = $this->repository->findRestaurants($limit, $offset, $params);

        if (0 < count($restaurants))
            if (false === $this->authChecker->isGranted('LISTING', current($restaurants)))
                throw new AccessDeniedException('Accesso non autorizzato!');

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

    /**
     * Delete an entity
     *
     * @api
     *
     * @param $entity
     * @return mixed
     */
    public function delete($entity)
    {

    }
}
