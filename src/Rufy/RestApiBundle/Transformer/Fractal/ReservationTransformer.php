<?php namespace Rufy\RestApiBundle\Transformer\Fractal;

use League\Fractal;

use Rufy\RestApiBundle\Entity\Reservation;

class ReservationTransformer extends Fractal\TransformerAbstract
{
    public function transform(Reservation $reservation) {

        return [

            'id'            => $reservation->getId(),
            'name'          => $reservation->getCustomer()->getName(),
            'phone'         => $reservation->getCustomer()->getPhone(),
            'area'          => $reservation->getArea()->getName(),
            'tableName'     => $reservation->getTableName(),
            'turn'          => $reservation->getTurn()->getName(),
            'people'        => $reservation->getPeople(),
            'date'          => $reservation->getDate()->format('d-m-Y'),
            'time'          => $reservation->getTime()->format('H:i'),
            'confirmed'     => (int) $reservation->getConfirmed(),
            'waiting'       => (int) $reservation->getWaiting(),
            'drawingWidth'  => $reservation->getDrawingWidth(),
            'drawingHeight' => $reservation->getDrawingHeight(),
            'drawingPosX'   => $reservation->getDrawingPosX(),
            'drawingPosY'   => $reservation->getDrawingPosY(),
        ];
    }
}
