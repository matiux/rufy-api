<?php namespace Rufy\RestApiBundle\Tests\Handler;

use Rufy\RestApiBundle\Handler\ReservationHandler;
use Rufy\RestApiBundle\Model\ReservationInterface;
use Rufy\RestApiBundle\Entity\Reservation;

class ReservationHandlerTest extends \PHPUnit_Framework_TestCase
{
    const RESERVATION_CLASS = 'Rufy\RestApiBundle\Tests\Handler\DummyReservation';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $om;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $repository;

    public function setUp()
    {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run.');
        }

        /**
         * We then create a dummy Lights object by calling PHPUnit's getMock() method and passing the
         * name of the Lights class. This returns an instance of Lights, but every method returns null--a dummy
         * object. This dummy object cannot do anything, but it gives our code the interface necessary to work
         * with Light objects.
         */
        $class              = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->om           = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository   = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::RESERVATION_CLASS))
            ->will($this->returnValue($this->repository));

        $this->om->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::RESERVATION_CLASS))
            ->will($this->returnValue($class));

        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::RESERVATION_CLASS));
    }

    public function testGet()
    {
//        $id                 = 1;
//        $reservation        = $this->getReservation();
//
//        $this->repository->expects($this->once())->method('find')
//            ->with($this->equalTo($id))
//            ->will($this->returnValue($reservation));
//
//        $this->reservationHandler = $this->createReservationHandler($this->om, static::RESERVATION_CLASS);
//
//        $this->reservationHandler->get($id);
    }

    protected function createReservationHandler($objectManager, $reservationClass)
    {
        return new ReservationHandler($objectManager, $reservationClass);
    }

    protected function getReservation()
    {
        $reservationClass = static::RESERVATION_CLASS;

        return new $reservationClass();
    }
}

class DummyReservation extends Reservation
{
}
