<?php namespace Rufy\RestApiBundle\Repository; 

use Doctrine\ORM\EntityRepository;

class RestaurantRepository extends EntityRepository
{
    /**
     * Find a restaurant by id
     *
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCustom($id)
    {
        return $this->find($id);
    }
}
