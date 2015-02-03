<?php namespace Rufy\RestApiBundle\DataFixtures\ORM;

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
        $restaurant->setName('MangiaApporco');
        $restaurant->setRestDate(2);
        $this->setReference('restaurant1', $restaurant);


        $restaurant = new Restaurant();
        $restaurant->setName('Mangio Abbestia');
        $restaurant->setRestDate(1);
        $this->setReference('restaurant2', $restaurant);
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
