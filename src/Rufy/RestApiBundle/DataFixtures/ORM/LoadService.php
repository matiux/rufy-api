<?php namespace Rufy\RestApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rufy\RestApiBundle\Entity\Service;

class LoadService extends AbstractFixture implements OrderedFixtureInterface
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

        $service = new Service();
        $service->setName('Pranzo');
        $service->setRestaurant($this->getReference('restaurant1'));
        $service->addTurn($this->getReference('turn_1'));
        $restaurant1->addService($service);
        $this->setReference('service_pranzo', $service);

        $service = new Service();
        $service->setName('Cena');
        $service->setRestaurant($this->getReference('restaurant1'));
        $service->addTurn($this->getReference('turn_2'));
        $service->addTurn($this->getReference('turn_3'));
        $restaurant1->addService($service);
        $this->setReference('service_cena', $service);

        $service = new Service();
        $service->setName('Cena');
        $service->setRestaurant($this->getReference('restaurant2'));
        $service->addTurn($this->getReference('turn_4'));
        $restaurant2->addService($service);
        $this->setReference('service_cena_rist_2', $service);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 40;
    }
}
