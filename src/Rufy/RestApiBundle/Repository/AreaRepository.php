<?php namespace Rufy\RestApiBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\ORM\EntityRepository,
    Doctrine\ORM\PersistentCollection;

use Rufy\RestApiBundle\Entity\Area,
    Rufy\RestApiBundle\Entity\Reservation,
    Rufy\RestApiBundle\Entity\User;

class AreaRepository extends EntityRepository implements EntityRepositoryInterface
{
    public function hasOptions(Reservation $reservation)
    {
        /**
         * @var $area Area
         * @var $areaOptions PersistentCollection - Le opzioni valide per una determinata Area
         * @var $reservationAreaOptions ArrayCollection
         */
        $area                       = $reservation->getArea();
        $areaOptions                = $area->getAreaOptions();
        $reservationAreaOptions     = $reservation->getReservationOptions();

        if (!$areaOptions->isEmpty()) {

            //$col = $reservationAreaOptions->map(function($o) use ($areaOptions) {
            //
            //    return $areaOptions->contains($o);
            //
            //});
            foreach ($reservationAreaOptions as $resOpt)
                if (!$areaOptions->contains($resOpt))
                    return false;

        }

        return true;
    }

    public function hasUser(Area $area, User $user)
    {
        $restaurantUsers    = $area->getRestaurant()->getUsers();

        if ($restaurantUsers)
            foreach ($restaurantUsers as $restaurantUser)
                if ($restaurantUser->getId() == $user->getId())
                    return true;

        return false;
    }

    /**
     * {@inheritdoc }
     */
    public function findMore($limit, $offset, $params, $filters = array())
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

        foreach ($filters as $filter => $value)
            $q = $q->andWhere("rese.$filter = :{$filter}value")->setParameter("{$filter}value", $value);

        $q = $q->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery();

        $areas = $q->getResult();

        return $areas ? $areas : false;
    }
}
