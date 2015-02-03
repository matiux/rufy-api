<?php namespace Rufy\RestApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rufy\RestApiBundle\Entity\Turn;

class LoadTurn extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $turn               = new Turn();
        $turn->setName('Primo turno pranzo');
        $this->setReference('turn_1', $turn);

        $turn               = new Turn();
        $turn->setName('Primo turno Cena');
        $this->setReference('turn_2', $turn);

        $turn               = new Turn();
        $turn->setName('Secondo turno Cena');
        $this->setReference('turn_3', $turn);

        $turn               = new Turn();
        $turn->setName('Unico turno serale');
        $this->setReference('turn_4', $turn);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 30;
    }
}
