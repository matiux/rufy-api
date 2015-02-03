<?php namespace Rufy\RestApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rufy\RestApiBundle\Entity\Reservation;

class LoadReservation extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $reservation    = new Reservation();
        $reservation->setCustomer($this->getReference('customer_1'));
        $reservation->setArea($this->getReference('area_1'));
        $reservation->setUser($this->getReference('user_matteo'));
        $reservation->setPeople(6);
        $reservation->setTime(new \DateTime('20:45'));
        $reservation->setDate(new \DateTime('31-12-2014'));
        $reservation->setConfirmed(false);
        $reservation->setWaiting(false);
        $reservation->setTableName('5');
        $reservation->setDrawingWidth(20);
        $reservation->setDrawingHeight(10);
        $reservation->setDrawingPosX(50);
        $reservation->setDrawingPosY(80);
        $reservation->setTurn($this->getReference('turn_1'));

        $this->getReference('user_matteo')->addReservation($reservation);

        $reservation    = new Reservation();
        $reservation->setCustomer($this->getReference('customer_2'));
        $reservation->setArea($this->getReference('area_1'));
        $reservation->setUser($this->getReference('user_emanuele'));
        $reservation->setPeople(12);
        $reservation->setTime(new \DateTime('21:30'));
        $reservation->setDate(new \DateTime('31-12-2014'));
        $reservation->setConfirmed(true);
        $reservation->setWaiting(false);
        $reservation->setTableName('12');
        $reservation->setDrawingWidth(50);
        $reservation->setDrawingHeight(10);
        $reservation->setDrawingPosX(125);
        $reservation->setDrawingPosY(90);
        $reservation->setTurn($this->getReference('turn_2'));

        $this->getReference('user_emanuele')->addReservation($reservation);

        $reservation    = new Reservation();
        $reservation->setCustomer($this->getReference('customer_3'));
        $reservation->setArea($this->getReference('area_3'));
        $reservation->setUser($this->getReference('user_pincopallo'));
        $reservation->setPeople(3);
        $reservation->setTime(new \DateTime('21:30'));
        $reservation->setDate(new \DateTime('31-12-2014'));
        $reservation->setConfirmed(true);
        $reservation->setWaiting(false);
        $reservation->setTableName('12');
        $reservation->setDrawingWidth(50);
        $reservation->setDrawingHeight(10);
        $reservation->setDrawingPosX(125);
        $reservation->setDrawingPosY(90);
        $reservation->setTurn($this->getReference('turn_3'));

        $this->getReference('user_pincopallo')->addReservation($reservation);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 70;
    }
}
