<?php namespace Rufy\RestApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rufy\RestApiBundle\Entity\User;

class LoadUser extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('matiux');
        $user->setIsActive(true);
        $user->setName('Matteo');
        $user->addRestaurant($this->getReference('restaurant'));
        $this->addReference('user_matteo', $user);

        $user = new User();
        $user->setUsername('ingro');
        $user->setIsActive(true);
        $user->setName('Emanuele');
        $user->addRestaurant($this->getReference('restaurant'));

        $this->addReference('user_emanuele', $user);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 20;
    }
}
