<?php namespace Rufy\RestApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\Doctrine,
    Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use Rufy\RestApiBundle\Entity\Customer;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;

class LoadCustomer extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
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
        $populator      = $this->container->get('faker.generator');
        $faker          = $populator->create();

        $ristoranti     = [

            $this->getReference('pousada'),
            $this->getReference('hotelito'),
            $this->getReference('lochiamavanocariola'),
        ];

        for ($i = 1; $i <= 20; $i++) {

            $customer = new Customer();
            $customer->setName($faker->name);
            $customer->setSurname($faker->lastName);
            $customer->setPhone($faker->phoneNumber);
            $customer->setEmail($faker->email);
            $customer->setPrivacy(true);
            $customer->setNewsletter(true);
            $customer->setRestaurant($ristoranti[rand(0, 2)]);

            $this->setReference('customer_1', $customer);
        }
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
