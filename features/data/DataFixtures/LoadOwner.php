<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rufy\RestApiBundle\Entity\Owner;

class LoadOwner extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    function load(ObjectManager $manager)
    {
        $owner = new Owner();
        $owner->setName('Matteo');
        $owner->setSurname('Galacci');
        $owner->setActive(1);
        $owner->setEmail('m.galacci@gmail.com');
        $owner->setPhone('3397476790');
        $owner->addUser($this->getReference('user_matteo'));
        $owner->addUser($this->getReference('user_pinco'));
        $owner->addUser($this->getReference('user_mat'));
        $this->addReference('owner1', $owner);
        $manager->persist($owner);

        $owner = new Owner();
        $owner->setName('Mario');
        $owner->setSurname('Rossi');
        $owner->setActive(1);
        $owner->setEmail('m.rossi@gmail.com');
        $owner->setPhone('1234567989');
        $owner->addUser($this->getReference('user_emanuele'));
        $this->addReference('owner2', $owner);
        $manager->persist($owner);

        $manager->persist($this->getReference('set_animali.ammessi'));
        $manager->persist($this->getReference('set_telefono.obbligatorio'));
        $manager->persist($this->getReference('set_nome.cognome.separati'));

        $manager->persist($this->getReference('role_admin'));
        $manager->persist($this->getReference('role_user'));
        $manager->persist($this->getReference('role_owner'));
        $manager->persist($this->getReference('role_reader'));

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    function getOrder()
    {
        return 1000; // ordine in cui le fixture saranno caricate
    }
}
