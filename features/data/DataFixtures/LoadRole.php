<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rufy\RestApiBundle\Entity\Role;

class LoadRole extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $roles = [

            'admin',
            'owner',
            'user',
            'reader',
        ];

        foreach ($roles as $roleName) {

            $role = new Role();
            $role->setName($roleName);
            $role->setRole('ROLE_'.strtoupper($roleName));

            $this->setReference('role_'.$roleName, $role);
        }
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 15;
    }
}
