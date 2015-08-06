<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Symfony\Component\HttpFoundation\Request;

interface EntityHandlerInterface
{
    /**
     * Get a Entity given the identifier
     *
     * @param int $id
     *
     * @return Entity
     */

    public function get($id);

    /**
     * Get a list of Reservations.
     *
     * @param int $limit            The limit of the result
     * @param int $offset           Starting from the offset
     * @param array $filters        Array of filters
     * @param array $params         Filter params
     *
     * @return array
     *
     * @throws AccessDeniedException if the resource is not accessible
     */
    public function all($limit = 5, $offset = 0, $filters = array(), $params = array());

    /**
     * Post Entity, creates a new Entity.
     *
     * @param Request $request
     * @return mixed
     */
    public function post(Request $request);

    /**
     * Edit a Entity.
     *
     * @param $entity
     * @param array           $parameters
     *
     * @return Entity
     */

    public function put($entity, array $parameters);

    /**
     * Partially update a Entity.
     *
     * @param $entity
     * @param array $parameters
     *
     * @return Entity
     */
    public function patch($entity, array $parameters);

    /**
     * Delete an entity
     *
     * @param $entity
     * @return mixed
     */
    public function delete($entity);
}
