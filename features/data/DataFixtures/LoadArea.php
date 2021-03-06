<?php

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
        $area->setRestaurant($pousada);
        $area->setMaxPeople(22);
        $area->setMaxPeopleTable('4');
        $area->setMinPeopleTable(14);
        $this->setReference('area_1', $area);
        $pousada->addArea($area);

        $area = new Area();
        $area->setName('1° Piano  - Sala Grande');
        $area->setMaxPeople(15);
        $area->setMaxPeopleTable('2');
        $area->setMinPeopleTable(15);
        $area->setRestaurant($hotelito);
        $this->setReference('area_2', $area);
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
