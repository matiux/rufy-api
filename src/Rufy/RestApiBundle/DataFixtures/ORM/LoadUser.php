<?php namespace Rufy\RestApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\Doctrine,
    Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use Rufy\RestApiBundle\Entity\User;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUser extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $user       = new User();
        $encoder    = $this->container->get('security.password_encoder');

        $user->setUsername('matiux');
        $user->setPassword($encoder->encodePassword($user, '281285'));
        $user->setIsActive(true);
        $user->addRole($this->getReference('role_admin'));
        $user->setName('Matteo');
        $user->setEmail('m.galacci@gmail.com');
        $user->addRestaurant($this->getReference('pousada'));
        $user->addRestaurant($this->getReference('hotelito'));
        $this->addReference('user_matteo', $user);
        $manager->persist($user);

        $user       = new User();
        $user->setUsername('ingro');
        $user->setPassword($encoder->encodePassword($user, 'eleuname'));
        $user->setIsActive(true);
        $user->addRole($this->getReference('role_admin'));
        $user->setName('Emanuele');
        $user->setEmail('ingro85@gmail.com ');
        $user->addRestaurant($this->getReference('lochiamavanocariola'));
        $this->addReference('user_emanuele', $user);
        $manager->persist($user);

        $manager->flush();
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

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
