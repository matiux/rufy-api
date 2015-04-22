<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rufy\RestApiBundle\Entity\Customer;

class LoadCustomer extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $customer = new Customer();
        $customer->setName('Ciccio');
        $customer->setSurname('Panza');
        $customer->setPhone('3397476790');
        $customer->setEmail('ciccio@paanza.it');
        $customer->setPrivacy(true);
        $customer->setNewsletter(true);
        $customer->setRestaurant($this->getReference('pousada'));

        $this->setReference('customer_1', $customer);

        $customer = new Customer();
        $customer->setName('Pancia');
        $customer->setSurname('Sfonda');
        $customer->setPhone('369852147');
        $customer->setEmail('pancia@sfonda.com');
        $customer->setPrivacy(false);
        $customer->setNewsletter(false);
        $customer->setRestaurant($this->getReference('pousada'));

        $this->setReference('customer_2', $customer);

        $customer = new Customer();
        $customer->setName('Pinco');
        $customer->setSurname('Pallo');
        $customer->setPhone('369852147');
        $customer->setEmail('pinco@pallo.com');
        $customer->setPrivacy(false);
        $customer->setNewsletter(false);
        $customer->setRestaurant($this->getReference('hotelito'));

        $this->setReference('customer_3', $customer);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 60;
    }
}
