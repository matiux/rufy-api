<?php namespace Rufy\RestApiBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\ORM\EntityRepository,
    Doctrine\ORM\PersistentCollection;

use Rufy\RestApiBundle\Entity\Area,
    Rufy\RestApiBundle\Entity\Reservation,
    Rufy\RestApiBundle\Entity\User;

class AreaRepository extends EntityRepository implements EntityRepositoryInterface
{
    /**
     * {@inheritdoc }
     */
    public function findMore($limit, $offset, $params, $filters = [])
    {
        $restaurantId = $params['restaurantId'];

//        $q = $this->createQueryBuilder('rese')
//            ->addSelect('a, rest')
//            ->leftJoin('rese.area', 'a')
//            ->leftJoin('a.restaurant', 'rest')
//            ->where('rest.id = :restaurantid')
//            ->setParameter('restaurantid', $restaurantId);

        $q = $this->createQueryBuilder('area')
            ->where('area.restaurant = :restaurantid')
            ->setParameter('restaurantid', $restaurantId);

        foreach ($filters as $filter => $value) {

            $q = $q->andWhere("rese.$filter = :{$filter}value")->setParameter("{$filter}value", $value);
        }

        if (0 != $limit) {
            $q = $q->setMaxResults($limit)->setFirstResult($offset);
        }

        $q      = $q->getQuery();
        $areas  = $q->getResult();

        return $areas ? $areas : false;
    }
}
