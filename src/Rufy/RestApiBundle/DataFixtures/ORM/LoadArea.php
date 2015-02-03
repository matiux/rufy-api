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
        $restaurant1 = $this->getReference('restaurant1');
        $restaurant2 = $this->getReference('restaurant2');

        $area = new Area();
        $area->setName('2° Piano  - Terrazzo');
        $area->setRestaurant($this->getReference('restaurant1'));
        $area->setOutside(true);
        $area->setSmokers(true);
        $area->setFull(false);
        $area->setInvalids(false);
        $area->setAnimals(true);
        $this->setReference('area_1', $area);
        $restaurant1->addArea($area);

        $area = new Area();
        $area->setName('1° Piano  - Sala Grande');
        $area->setRestaurant($this->getReference('restaurant1'));
        $area->setOutside(false);
        $area->setSmokers(false);
        $area->setFull(true);
        $area->setInvalids(true);
        $area->setAnimals(false);
        $this->setReference('area_2', $area);
        $restaurant1->addArea($area);

        $area = new Area();
        $area->setName('Corridoio Esterno');
        $area->setRestaurant($this->getReference('restaurant2'));
        $area->setOutside(false);
        $area->setSmokers(false);
        $area->setFull(true);
        $area->setInvalids(true);
        $area->setAnimals(false);
        $this->setReference('area_3', $area);
        $restaurant2->addArea($area);
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
