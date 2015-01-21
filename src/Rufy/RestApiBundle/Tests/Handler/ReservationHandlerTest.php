<?php namespace Rufy\RestApiBundle\Tests\Handler;

use Rufy\RestApiBundle\Handler\ReservationHandler;
use Rufy\RestApiBundle\Model\ReservationInterface;
use Rufy\RestApiBundle\Entity\Reservation;

class ReservationHandlerTest extends \PHPUnit_Framework_TestCase
{
    //const PAGE_CLASS = 'Rufy\RestApiBundle\Tests\Handler\DummyReservation';

    public function testGet()
    {
        $id                 = 1;
        $reservation        = $this->getReservation();  // create a Reservation object

        // I expect that the Reservation repository is called with find(1)
        $this->repository->expects($this->once())
            ->method('find')
            ->with($this->equalTo($id))
            ->will($this->returnValue($reservation));

        $this->reservationHandler->get($id); // call the get.
    }
}
