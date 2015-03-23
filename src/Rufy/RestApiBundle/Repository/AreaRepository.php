<?php namespace Rufy\RestApiBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\ORM\EntityRepository,
    Doctrine\ORM\PersistentCollection;

use Rufy\RestApiBundle\Entity\Area,
    Rufy\RestApiBundle\Entity\Reservation;

class AreaRepository extends EntityRepository
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
}
