<?php namespace Rufy\RestApiBundle\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\NoResultException;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReservationRepository extends EntityRepository implements EntityRepositoryInterface
{
    /**
     * Find a reservation by id
     *
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCustom($id)
    {
        //$reservation = $this->find($id);

        $q = $this->createQueryBuilder('rese')
            ->select('rese, a, c, opt')
            ->join('rese.area', 'a')
            ->join('rese.customer', 'c')
            ->leftJoin('rese.reservationOptions', 'opt')
            ->where('rese.id = :reservationid')
            ->setParameter('reservationid', $id)
            ->getQuery();

        try {

            $reservation = $q->getSingleResult();

            return $reservation;

        } catch (NoResultException $e) {

            return false;
        }
    }

    /**
     * {@inheritdoc }
     */
    public function findMore($limit, $offset, $params, $filters = array())
    {
        $restaurantId = $params['restaurantId'];

        $q = $this->createQueryBuilder('rese')
            ->addSelect('a, rest, c')
            ->join('rese.area', 'a')
            ->join('a.restaurant', 'rest')
            ->join('rese.customer', 'c')
            ->where('rest.id = :restaurantid')
            ->setParameter('restaurantid', $restaurantId);

        foreach ($filters as $filter => $value) {

            if (!is_array($value) && false === strpos($filter, '.')) {

                $q = $q->andWhere("rese.$filter = :{$filter}value")->setParameter("{$filter}value", $value);

            } else if (false !== strpos($filter, '.')) {

                switch ($filter) {

                    case 'customer.name':
                        $q = $q->andWhere("c.name LIKE :cnamevalue")->setParameter('cnamevalue', "%$value%");
                        break;
                    case 'customer.phone':
                        $q = $q->andWhere("c.phone LIKE :cphonevalue")->setParameter('cphonevalue', "%$value%");
                        break;
                    case 'customer.email':
                        $q = $q->andWhere("c.email LIKE :cemailvalue")->setParameter('cemailvalue', "%$value%");
                        break;
                }
            }
            else {
                $q = $q->andWhere("rese.$filter IN (:{$filter}value)")->setParameter("{$filter}value", $value);
            }
        }

        if (0 != $limit) {
            $q = $q->setMaxResults($limit)->setFirstResult($offset);
        }

        $q              = $q->getQuery();
        $reservations   = $q->getResult();

        return $reservations ? $reservations : false;
    }
}
