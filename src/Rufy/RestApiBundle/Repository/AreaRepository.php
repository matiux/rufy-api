<?php namespace Rufy\RestApiBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Rufy\RestApiBundle\Entity\Area;
use Rufy\RestApiBundle\Entity\Reservation;
use Rufy\RestApiBundle\Entity\ReservationOption;

class AreaRepository extends EntityRepository
{
    public function hasOptions(Reservation $reservation)
    {
        $areaOptions            = $reservation->getArea()->getAreaOptions();

        $areaId                 = $reservation->getArea()->getId();

        /**
         * Ciclo le opzioni appartenenti all'area utilizzata per la prenotazione
         */
        foreach ($areaOptions as $opt) {
            /**
             * @var $opt ReservationOption
             */
            $slug = $opt->getSlug();

        }


        /**
         * @var $area Area;
         */
        $area                   = $reservation->getArea();

        $reservationOptions     = $reservation->getReservationOptions()->toArray();

        $options                = $area->getAreaOptions();

        return true;
    }
}
