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
        $restaurant = $this->getReference('restaurant');

        $area = new Area();
        $area->setName('2° Piano  - Terrazzo');
        $area->setRestaurant($this->getReference('restaurant'));
        $area->setOutside(true);
        $area->setSmokers(true);
        $area->setFull(false);
        $area->setInvalids(false);
        $area->setAnimals(true);

        $restaurant->addArea($area);

        $area = new Area();
        $area->setName('1° Piano  - Sala Grande');
        $area->setRestaurant($this->getReference('restaurant'));
        $area->setOutside(false);
        $area->setSmokers(false);
        $area->setFull(true);
        $area->setInvalids(true);
        $area->setAnimals(false);

        $restaurant->addArea($area);
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
