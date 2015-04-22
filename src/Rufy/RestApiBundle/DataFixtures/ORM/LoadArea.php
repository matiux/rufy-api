<?php namespace Rufy\RestApiBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rufy\RestApiBundle\Entity\Area;

class LoadArea extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $pousada        = $this->getReference('pousada');
        $hotelito       = $this->getReference('hotelito');

        $ristoranti     = [

            'pousada'   => [

                'Corridoio'     => ['maxPeople' => 10, 'options' => ['animals']],
                'Sala'          => ['maxPeople' => 14, 'options' => ['animals']],
                'Atras'         => ['maxPeople' => 6, 'options' => ['animals']],
                'Tondo'         => ['maxPeople' => 5, 'options' => ['animals']],
                'Frida'         => ['maxPeople' => 22, 'options' => ['animals']],
                'Camarote'      => ['maxPeople' => 20, 'options' => ['animals']],
                'Fuori'         => ['maxPeople' => 25, 'options' => ['animals', 'smokers']],

            ],
            'hotelito'  => [

                'Tavoli da 2'   => ['maxPeople' => 8, 'options' => ['animals']],
                'Fronte'        => ['maxPeople' => 30, 'options' => ['animals']],
                'Lato'          => ['maxPeople' => 22, 'options' => ['animals']],
                'Tenda'         => ['maxPeople' => 18, 'options' => ['animals', 'smokers']],
                'Fuori'         => ['maxPeople' => 44, 'options' => ['animals', 'smokers']],
            ],
        ];

        foreach ($ristoranti as $ristoName => $aree) {

            foreach ($aree as $areaName => $areaData) {

                $areaObj    = new Area();
                $areaObj->setName($areaName);
                $areaObj->setRestaurant($this->getReference($ristoName));
                $areaObj->setFull(0);
                $areaObj->setMaxPeople($areaData['maxPeople']);

                foreach($areaData['options'] as $opt)
                    $areaObj->addAreaOption($this->getReference("reservationOption_$opt"));

                $this->setReference($areaName, $areaObj);
            }
        }
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 50;
    }
}
