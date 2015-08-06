<?php namespace Rufy\RestApiBundle\Transformer\Fractal;

use League\Fractal;

use Rufy\RestApiBundle\Entity\Reservation;

class ReservationTransformer extends Fractal\TransformerAbstract
{
    protected $defaultIncludes = [

        //'reservationOptions',
        'customer',
    ];

    public function transform(Reservation $reservation)
    {
        return [
            'id'                        => $reservation->getId(),
            'people'                    => $reservation->getPeople(),
            'time'                      => $reservation->getTime()->format('H:i'),
            'date'                      => $reservation->getDate()->format('d/m/Y'),
            'note'                      => $reservation->getNote(),
            'people_extra'              => $reservation->getPeopleExtra(),
            'status'                    => $reservation->getStatus(),
            'table_name'                => $reservation->getTableName(),
            //'customer'                  => $reservation->getCustomer(),
            'area'                      => $reservation->getArea()->getId(),


//            'name'          => $reservation->getCustomer()->getName(),
//            'phone'         => $reservation->getCustomer()->getPhone(),
//            'area_name'     => $reservation->getArea()->getName(),
//            'restaurantId'  => $reservation->getArea()->getRestaurant()->getId(),
        ];
    }

    public function includeReservationOptions(Reservation $reservation)
    {
        $opts = $reservation->getReservationOptions();

        return $this->collection($opts, new ReservationOptionTransformer);
    }

    public function includeCustomer(Reservation $reservation)
    {
        $customer = $reservation->getCustomer();

        return $this->item($customer, new CustomerTransformer());
    }
}
