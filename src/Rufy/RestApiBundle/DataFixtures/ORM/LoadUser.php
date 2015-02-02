<?php namespace Rufy\RestApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rufy\RestApiBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
        $encoder    = $this->container->get('security.encoder_factory')->getEncoder($user);

        $user->setUsername('matiux');
        $user->setPassword($encoder->encodePassword('281285', $user->getSalt()));
        $user->setIsActive(true);
        $user->setRoles('ROLE_ADMIN');
        $user->setName('Matteo');
        $user->addRestaurant($this->getReference('restaurant'));
        $this->addReference('user_matteo', $user);

        $user       = new User();
        $encoder    = $this->container->get('security.encoder_factory')->getEncoder($user);
        $user->setUsername('ingro');
        $user->setPassword($encoder->encodePassword('eleuname', $user->getSalt()));
        $user->setIsActive(true);
        $user->setRoles('ROLE_ADMIN');
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
