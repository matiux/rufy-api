<?php namespace Rufy\RestApiBundle\DataFixtures\ORM;

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

        $owner->addUser($this->getReference('user_emanuele'));
        $owner->addUser($this->getReference('user_matteo'));

        $this->addReference('owner', $owner);

        $manager->persist($this->getReference('set_animali.ammessi'));
        $manager->persist($this->getReference('set_telefono.obbligatorio'));
        $manager->persist($this->getReference('set_nome.cognome.separati'));

        $manager->persist($this->getReference('role_admin'));
        $manager->persist($this->getReference('role_user'));
        $manager->persist($this->getReference('role_visitor'));

        $manager->persist($owner);
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
