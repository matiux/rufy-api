<?php namespace Rufy\RestApiBundle\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\NoResultException;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerRepository extends EntityRepository implements EntityRepositoryInterface
{
    /**
     * {@inheritdoc }
     */
    public function findMore($limit, $offset, $params, $filters = array())
    {
        $restaurantId = $params['restaurantId'];

        $q = $this->createQueryBuilder('c')
            ->where('c.restaurant = :restaurantid')
            ->setParameter('restaurantid', $restaurantId);

        foreach ($filters as $filter => $value)
            $q = $q->andWhere("c.$filter = :{$filter}value")->setParameter("{$filter}value", $value);

        $q = $q->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery();

        $customers = $q->getResult();

        return $customers ? $customers : false;
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
