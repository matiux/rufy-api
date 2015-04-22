<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rufy\RestApiBundle\Entity\ReservationOption;

class LoadReservationOption extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $options = [

            'smokers',
            'outside',
            'full',
            'invalids',
            'animals'
        ];

        foreach ($options as $option) {

            $restaurantOption = new ReservationOption();
            $restaurantOption->setSlug($option);

            $this->setReference('reservationOption_'.$option, $restaurantOption);
        }

    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 45;
    }
}
