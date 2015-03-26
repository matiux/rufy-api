<?php namespace Rufy\RestApiBundle\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\NoResultException;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReservationRepository extends EntityRepository implements EntityRepositoryInterface
{
//    /**
//     * @param \Reservation $reservation
//     * @param int $people
//     * @param int $height
//     * @return void
//     */
//    private function setTableDimension(\Reservation $reservation, $people, $height = 1)
//    {
//        $base = (($people % 2) == 0) ? ($people / 2) - 1 : floor($people / 2) ;
//
//        if (0 >= $base)
//            $base = 1;
//
//        if ($height > 1)
//            $base -= $height;
//
//        $reservation->setDrawingWidth($base);
//        $reservation->setDrawingHeight($height);
//
//        return;
//    }

//    /**
//     *
//     * @param \Reservation $reservation
//     * @param $params
//     */
//    private function setTablePosition(\Reservation $reservation, $params) {
//
//        $reservation->setDrawingPosX(20);
//        $reservation->setDrawingPosY(30);
//
//        return;
//    }

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
            ->leftJoin('rese.area', 'a')
            ->leftJoin('rese.customer', 'c')
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
            ->addSelect('a, rest')
            ->leftJoin('rese.area', 'a')
            ->leftJoin('a.restaurant', 'rest')
            ->where('rest.id = :restaurantid')
            ->setParameter('restaurantid', $restaurantId);

        foreach ($filters as $filter => $value)
            $q = $q->andWhere("rese.$filter = :{$filter}value")->setParameter("{$filter}value", $value);

        $q = $q->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery();

        $reservations = $q->getResult();

        return $reservations ? $reservations : false;
    }
}
