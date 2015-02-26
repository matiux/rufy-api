<?php namespace Rufy\RestApiBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Rufy\RestApiBundle\Entity\Area;
use Rufy\RestApiBundle\Entity\Reservation;

class AreaRepository extends EntityRepository
{
    public function hasOptions(Reservation $reservation)
    {
        //$areaOptions            = $reservation->getArea()->getAreaOptions();
        $areaId                 = $reservation->getArea()->getId();
        /**
         * @var $area Area;
         */
        $area                   = $reservation->getArea();

        $reservationOptions     = $reservation->getReservationOptions()->toArray();

        $options                = $area->getAreaOptions();

        return true;
    }
}
