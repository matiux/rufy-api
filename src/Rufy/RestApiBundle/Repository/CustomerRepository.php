<?php namespace Rufy\RestApiBundle\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\NoResultException;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerRepository extends EntityRepository implements EntityRepositoryInterface
{
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
    public function findMore($limit, $offset, $params, $filters = array())
    {

    }

    /**
     * Find a customer by id
     *
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCustom($id)
    {
        $customer = $this->findOneById($id);

        return $customer;
    }
}
