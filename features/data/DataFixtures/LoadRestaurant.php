<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rufy\RestApiBundle\Entity\Restaurant;

class LoadRestaurant extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $restaurant = new Restaurant();
        $restaurant->setName('Pousada');
        $restaurant->setRestDate(2);
        $this->setReference('pousada', $restaurant);

        $restaurant = new Restaurant();
        $restaurant->setName('Hotelito');
        $restaurant->setRestDate(1);
        $this->setReference('hotelito', $restaurant);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 10;
    }
}
