<?php namespace Rufy\RestApiBundle\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\NoResultException;

use Doctrine\ORM\QueryBuilder;
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
     * TODO - Rifattorizzare
     * {@inheritdoc }
     */
    public function findMore($limit, $offset, $params, $filters = array())
    {
        $restaurantId   = $params['restaurantId'];

        $q = $this->createQueryBuilder('rese')
            ->addSelect('a, rest, c')
            ->join('rese.area', 'a')
            ->join('a.restaurant', 'rest')
            ->join('rese.customer', 'c')
            ->where('rest.id = :restaurantid')
            ->setParameter('restaurantid', $restaurantId);

        $this->handleFilters($filters, $q);

        if (0 != $limit) {
            $q = $q->setMaxResults($limit)->setFirstResult($offset);
        }

        $q              = $q->getQuery();
        $reservations   = $q->getResult();

        return $reservations ?: false;
    }

    private function handleFilters(array $filters, QueryBuilder $q)
    {
        /**
         * TODO
         * Tirare fuori da $filters quelli custom e gestirli separatamente....
         */
        $customFilters  = ['date_range', 'month'];

        foreach ($filters as $filter => $value) {

            if (false !== strpos($filter, 'customer_')) {

                $this->addCustomerFilter($filter, $value, $q);
            }
            else if(is_array($value)) {

                $q->andWhere("rese.$filter IN (:{$filter}value)")->setParameter("{$filter}value", $value);

            } else if ('date_range' == $filter) {

                $dates = explode('|', $value);

                $q->where('rese.date BETWEEN :start AND :end')
                    ->setParameter('start', $dates[0])
                    ->setParameter('end', $dates[1]);


            } else {

                $q->andWhere("rese.$filter = :{$filter}value")->setParameter("{$filter}value", $value);
            }
        }
    }

    private function addCustomerFilter($filter, $value, QueryBuilder $q)
    {
        switch ($filter) {

            case 'customer_name':
                $q->andWhere("c.name LIKE :cnamevalue")->setParameter('cnamevalue', "%$value%");
                break;
            case 'customer_phone':
                $q->andWhere("c.phone LIKE :cphonevalue")->setParameter('cphonevalue', "%$value%");
                break;
            case 'customer_email':
                $q->andWhere("c.email LIKE :cemailvalue")->setParameter('cemailvalue', "%$value%");
                break;
        }
    }
}
