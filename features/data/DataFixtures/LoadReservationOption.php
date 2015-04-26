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

            'Fumatori'  => 'smokers',
            'Fuori'     => 'outside',
            'Pieno'     => 'full',
            'Invalidi'  => 'invalids',
            'Animali'   => 'animals'
        ];

        foreach ($options as $option => $slug) {

            $restaurantOption = new ReservationOption();
            $restaurantOption->setSlug($slug);
            $restaurantOption->setName($option);

            $this->setReference('reservationOption_'.$slug, $restaurantOption);
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
