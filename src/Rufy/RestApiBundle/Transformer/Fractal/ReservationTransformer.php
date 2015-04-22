<?php namespace Rufy\RestApiBundle\Transformer\Fractal;

use League\Fractal;

use Rufy\RestApiBundle\Entity\Reservation;

class ReservationTransformer extends Fractal\TransformerAbstract
{
    protected $defaultIncludes = [
        'reservationOptions'
    ];

    public function transform(Reservation $reservation)
    {
        return [

            'id'            => $reservation->getId(),
            'name'          => $reservation->getCustomer()->getName(),
            'phone'         => $reservation->getCustomer()->getPhone(),
            'area'          => $reservation->getArea()->getName(),
            'areaId'        => $reservation->getArea()->getId(),
            'tableName'     => $reservation->getTableName(),
            'people'        => $reservation->getPeople(),
            'peopleExtra'   => $reservation->getPeopleExtra(),
            'date'          => $reservation->getDate()->format('Y-m-d'),
            'time'          => $reservation->getTime()->format('H:i'),
            'note'          => $reservation->getNote(),
            'status'        => $reservation->getStatus(),
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
