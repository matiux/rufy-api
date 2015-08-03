<?php

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
        $reservation->setPeopleExtra(0);
        $reservation->setTime(new \DateTime('20:45'));
        $reservation->setDate(new \DateTime('28-03-2015'));
        $reservation->setNote('Qualche nota circa la prenotazione');
        $reservation->setStatus(1);
        $reservation->addReservationOption($this->getReference('reservationOption_outside'));
        $reservation->addReservationOption($this->getReference('reservationOption_animals'));
        $reservation->setTableName('5');

        $this->getReference('user_matteo')->addReservation($reservation);

        $reservation    = new Reservation();
        $reservation->setCustomer($this->getReference('customer_2'));
        $reservation->setArea($this->getReference('area_2'));
        $reservation->setUser($this->getReference('user_emanuele'));
        $reservation->setPeople(12);
        $reservation->setTime(new \DateTime('21:30'));
        $reservation->setDate(new \DateTime('30-04-2015'));
        $reservation->setNote('Qualche nota circa la prenotazione');
        $reservation->setStatus(2);
        $reservation->addReservationOption($this->getReference('reservationOption_outside'));
        $reservation->addReservationOption($this->getReference('reservationOption_smokers'));
        $reservation->setTableName('12');

        $this->getReference('user_emanuele')->addReservation($reservation);

//        $reservation    = new Reservation();
//        $reservation->setCustomer($this->getReference('customer_3'));
//        $reservation->setArea($this->getReference('area_2'));
//        $reservation->setUser($this->getReference('user_pincopallo'));
//        $reservation->setPeople(3);
//        $reservation->setTime(new \DateTime('21:30'));
//        $reservation->setDate(new \DateTime('31-12-2014'));
//        $reservation->setStatus(0);
//        $reservation->addReservationOption($this->getReference('reservationOption_animals'));
//        $reservation->setNote('Qualche nota circa la prenotazione');
//        $reservation->setTableName('12');
//
//        $this->getReference('user_pincopallo')->addReservation($reservation);
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
