<?php namespace Rufy\RestApiBundle\Transformer\Fractal;

use League\Fractal;

use Rufy\RestApiBundle\Entity\Reservation;

class ReservationTransformer extends Fractal\TransformerAbstract
{
    protected $defaultIncludes = [
        'reservationOptions'
    ];

    public function transform(Reservation $reservation) {

//        $opts = $reservation->getReservationOptions();
//        $a = 1;
        return [

            'id'            => $reservation->getId(),
            'name'          => $reservation->getCustomer()->getName(),
            'phone'         => $reservation->getCustomer()->getPhone(),
            'area'          => $reservation->getArea()->getName(),
            'areaId'        => $reservation->getArea()->getId(),
            'tableName'     => $reservation->getTableName(),
            'people'        => $reservation->getPeople(),
            'date'          => $reservation->getDate()->format('d-m-Y'),
            'time'          => $reservation->getTime()->format('H:i'),
            'note'          => $reservation->getNote(),
            'confirmed'     => (int) $reservation->getConfirmed(),
            'waiting'       => (int) $reservation->getWaiting(),
            //'options'       => $reservation->getReservationOptions(),
            'drawingWidth'  => $reservation->getDrawingWidth(),
            'drawingHeight' => $reservation->getDrawingHeight(),
            'drawingPosX'   => $reservation->getDrawingPosX(),
            'drawingPosY'   => $reservation->getDrawingPosY(),
        ];
    }

    public function includeReservationOptions(Reservation $reservation)
    {
        $opts = $reservation->getReservationOptions();

        return $this->collection($opts, new ReservationOptionTransformer);
    }
}
