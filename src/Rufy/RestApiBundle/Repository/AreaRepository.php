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
        $reservationOptions     = $reservation->getReservationOptions()->toArray();



        return;
    }
}
