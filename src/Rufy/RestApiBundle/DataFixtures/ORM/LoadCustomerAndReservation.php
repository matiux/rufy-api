<?php namespace Rufy\RestApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\Doctrine,
    Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface,
    Doctrine\Common\Persistence\ObjectManager;

use Rufy\RestApiBundle\Entity\Customer,
    Rufy\RestApiBundle\Entity\Reservation;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;

use Faker\Factory;

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
        $faker = Factory::create();

        /**
         * Customer
         */
        $ristoranti     = [

            ['r' => 'pousada', 'o' => $this->getReference('pousada')],
            ['r' => 'hotelito', 'o' => $this->getReference('hotelito')],
            ['r' => 'lochiamavanocariola', 'o' => $this->getReference('lochiamavanocariola')],
        ];

        $cc = new \stdClass;
        $cc->p = [];
        $cc->h = [];
        $cc->l = [];

        for ($x = 1; $x <= 20; $x++) {

            $i = rand(0, 2);

            $customer = new Customer();
            $customer->setName("{$faker->firstName} {$faker->lastName}");
            $customer->setPhone($faker->phoneNumber);
            $customer->setEmail($faker->email);
            $customer->setPrivacy(true);
            $customer->setNewsletter(true);
            $customer->setRestaurant($ristoranti[$i]['o']);

            $this->setReference('customer_'.$ristoranti[$i]['r'].'_'.$x, $customer);

            $z = substr($ristoranti[$i]['r'], 0, 1);

            array_push($cc->$z, $x);

            $manager->persist($customer);
        }

        $manager->flush();

        /**
         * Reservation
         */
        $aree = [

            ['a' => 'Corridoio',  'r' => 'pousada', 'u' => 'user_matteo'],
            ['a' => 'Sala',  'r' => 'pousada', 'u' => 'user_matteo'],
            ['a' => 'Atras',  'r' => 'pousada', 'u' => 'user_matteo'],
            ['a' => 'Tondo',  'r' => 'pousada', 'u' => 'user_matteo'],
            ['a' => 'Frida',  'r' => 'pousada', 'u' => 'user_matteo'],
            ['a' => 'Camarote',  'r' => 'pousada', 'u' => 'user_matteo'],
            ['a' => 'Fuori',  'r' => 'pousada', 'u' => 'user_matteo'],

            ['a' => 'Tavoli da 2',  'r' => 'hotelito', 'u' => 'user_matteo'],
            ['a' => 'Fronte',  'r' => 'hotelito', 'u' => 'user_matteo'],
            ['a' => 'Lato',  'r' => 'hotelito', 'u' => 'user_matteo'],
            ['a' => 'Tenda',  'r' => 'hotelito', 'u' => 'user_matteo'],
            ['a' => 'Fuori',  'r' => 'hotelito', 'u' => 'user_matteo'],

            ['a' => 'Sopra',  'r' => 'hotelito', 'u' => 'user_emanuele'],
            ['a' => 'Sotto',  'r' => 'hotelito', 'u' => 'user_emanuele'],
            ['a' => 'Fuori',  'r' => 'hotelito', 'u' => 'user_emanuele'],
        ];

        $options = [

            'smokers',
            //'invalids',
            'animals',
        ];

        $users = [
            'user_matteo',
            'user_emanuele',
        ];

        for ($i = 1; $i <= 10; $i++) {

            $x              = rand(0,14);

            $reservation    = new Reservation();

            /**
             * TODO
             * impostare data minima da oggi
             */

            $reservation->setArea($this->getReference($aree[$x]['a']));
            $reservation->setUser($this->getReference($aree[$x]['u']));
            $reservation->setPeople(rand(2, 12));
            $reservation->setPeopleExtra(rand(1, 4));
            $reservation->setDate($faker->date('Y-m-d'));
            $reservation->setTime($faker->time('H:i:s'));
            $reservation->setNote($faker->text(rand(50, 200)));
            $reservation->setStatus(rand(0, 2));
            $reservation->addReservationOption($this->getReference('reservationOption_'.$options[rand(0, 1)]));
            $reservation->setTableName($faker->word);

            $z      = substr($aree[$x]['r'], 0, 1);
            $arr    = $cc->$z;

            $c      = 'customer_'.$aree[$x]['r'].'_'.$arr[rand(0, count($cc->$z) - 1)];

            $reservation->setCustomer($this->getReference($c));

            $reservation->setDrawingWidth(20);
            $reservation->setDrawingHeight(10);
            $reservation->setDrawingPosX(50);
            $reservation->setDrawingPosY(80);

            $this->getReference($aree[$x]['u'])->addReservation($reservation);

            $manager->persist($reservation);
        }

        $manager->flush();
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
