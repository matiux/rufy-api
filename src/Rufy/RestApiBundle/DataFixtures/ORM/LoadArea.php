<?php namespace Rufy\RestApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rufy\RestApiBundle\Entity\Area;

class LoadArea extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $pousada        = $this->getReference('pousada');
        $hotelito       = $this->getReference('hotelito');

        $area = new Area();
        $area->setName('2° Piano  - Terrazzo');
        $area->setRestaurant($this->getReference('pousada'));
        $area->setFull(0);
        $area->setMaxPeople(22);
        $area->addAreaOption($this->getReference('reservationOption_outside'));
        $area->addAreaOption($this->getReference('reservationOption_invalids'));
        $area->addAreaOption($this->getReference('reservationOption_animals'));
        $this->setReference('area_1', $area);
        $pousada->addArea($area);

        $area = new Area();
        $area->setName('1° Piano  - Sala Grande');
        $area->setFull(0);
        $area->setMaxPeople(15);
        $area->setRestaurant($this->getReference('pousada'));
        $area->addAreaOption($this->getReference('reservationOption_outside'));
        //$area->addAreaOption($this->getReference('reservationOption_invalids'));
        $area->addAreaOption($this->getReference('reservationOption_smokers'));
        $area->addAreaOption($this->getReference('reservationOption_animals'));
        $this->setReference('area_2', $area);
        $pousada->addArea($area);

        $area = new Area();
        $area->setName('Corridoio Esterno');
        $area->setFull(0);
        $area->setMaxPeople(46);
        $area->setRestaurant($this->getReference('hotelito'));
        $area->addAreaOption($this->getReference('reservationOption_invalids'));
        $area->addAreaOption($this->getReference('reservationOption_animals'));
        $this->setReference('area_3', $area);
        $hotelito->addArea($area);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 50;
    }
}
