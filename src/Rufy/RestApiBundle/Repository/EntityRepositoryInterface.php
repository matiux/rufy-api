<?php namespace Rufy\RestApiBundle\Repository;


interface EntityRepositoryInterface {

    /**
     * Find an entity
     *
     * @param $limit
     * @param $offset
     * @param $params
     * @param array $filters
     *
     * @return mixed
     */
    public function findMore($limit, $offset, $params, $filters = array());
}
