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
//        $ristoranti     = [
//
//            'pousada'   => [
//
//                'Corridoio'     => ['maxPeople' => 10, 'options' => ['animals'], 'maxPeopleTable' => 2, 'minPeopleTable' => 2 ],
//                'Sala'          => ['maxPeople' => 10, 'options' => ['animals'], 'maxPeopleTable' => 10, 'minPeopleTable' => 8],
//                'Atras'         => ['maxPeople' => 10, 'options' => ['animals'], 'maxPeopleTable' => 6, 'minPeopleTable' => 4],
//                'Tondo'         => ['maxPeople' => 5, 'options' => ['animals'], 'maxPeopleTable' => 5, 'minPeopleTable' => 3],
//                'Frida'         => ['maxPeople' => 22, 'options' => ['animals'], 'maxPeopleTable' => 22, 'minPeopleTable' => 4],
//                'Camarote'      => ['maxPeople' => 20, 'options' => ['animals'], 'maxPeopleTable' => 20, 'minPeopleTable' => 4],
//                'Fuori'         => ['maxPeople' => 25, 'options' => ['animals', 'smokers'], 'maxPeopleTable' => 15, 'minPeopleTable' => 2],
//
//            ],
//            'hotelito'  => [
//
//                'Tavoli da 2'   => ['maxPeople' => 6, 'options' => ['animals'], 'maxPeopleTable' => 2, 'minPeopleTable' => 2],
//                'Fronte'        => ['maxPeople' => 28, 'options' => ['animals'], 'maxPeopleTable' => 28, 'minPeopleTable' => 4],
//                'Lato'          => ['maxPeople' => 22, 'options' => ['animals'], 'maxPeopleTable' => 22, 'minPeopleTable' => 4],
//                'Tenda'         => ['maxPeople' => 18, 'options' => ['animals', 'smokers'], 'maxPeopleTable' => 10, 'minPeopleTable' => 4],
//                'Fuori'         => ['maxPeople' => 40, 'options' => ['animals', 'smokers'], 'maxPeopleTable' => 22, 'minPeopleTable' => 4],
//            ],
//            'lochiamavanocariola'   => [
//
//                'Sopra'         => ['maxPeople' => 58, 'options' => ['animals']],
//                'Sotto'         => ['maxPeople' => 65, 'options' => ['animals']],
//                'Fuori'         => ['maxPeople' => 28, 'options' => ['animals', 'smokers']],
//            ],
//        ];

        $ristoranti     = [

            'pousada'   => [

                'Corridoio'     => ['options' => [], 'maxPeople' => 10, 'maxPeopleTable' => 2, 'minPeopleTable' => 2 ],
                'Sala'          => ['options' => [], 'maxPeople' => 10, 'maxPeopleTable' => 10, 'minPeopleTable' => 8],
                'Atras'         => ['options' => [], 'maxPeople' => 10, 'maxPeopleTable' => 6, 'minPeopleTable' => 4],
                'Tondo'         => ['options' => [], 'maxPeople' => 5, 'maxPeopleTable' => 5, 'minPeopleTable' => 3],
                'Frida'         => ['options' => [], 'maxPeople' => 22, 'maxPeopleTable' => 22, 'minPeopleTable' => 4],
                'Camarote'      => ['options' => [], 'maxPeople' => 20, 'maxPeopleTable' => 20, 'minPeopleTable' => 4],
                'Fuori'         => ['options' => [], 'maxPeople' => 25, 'maxPeopleTable' => 15, 'minPeopleTable' => 2],
            ],
            'hotelito'  => [

                'Tavoli da 2'   => ['options' => [], 'maxPeople' => 6, 'maxPeopleTable' => 2, 'minPeopleTable' => 2],
                'Fronte'        => ['options' => [], 'maxPeople' => 28, 'maxPeopleTable' => 28, 'minPeopleTable' => 4],
                'Lato'          => ['options' => [], 'maxPeople' => 22, 'maxPeopleTable' => 22, 'minPeopleTable' => 4],
                'Tenda'         => ['options' => [], 'maxPeople' => 18, 'maxPeopleTable' => 10, 'minPeopleTable' => 4],
                'Fuori'         => ['options' => [], 'maxPeople' => 40, 'maxPeopleTable' => 22, 'minPeopleTable' => 4],
            ],
            'giardino' => [

                'esterno'       => ['options' => [], 'maxPeople' => 30, 'maxPeopleTable' => 15, 'minPeopleTable' => 3],
            ],
            'lochiamavanocariola'   => [

                'Sopra'         => ['options' => [], 'maxPeople' => 58, 'maxPeopleTable' => 15, 'minPeopleTable' => 3 ],
                'Sotto'         => ['options' => [], 'maxPeople' => 65, 'maxPeopleTable' => 15, 'minPeopleTable' => 3 ],
                'Fuori'         => ['options' => [], 'maxPeople' => 28, 'maxPeopleTable' => 15, 'minPeopleTable' => 3 ],
            ],
        ];

        foreach ($ristoranti as $ristoName => $aree) {

            foreach ($aree as $areaName => $areaData) {

                $areaObj    = new Area();
                $areaObj->setName($areaName);
                $areaObj->setRestaurant($this->getReference($ristoName));
                $areaObj->setMaxPeople($areaData['maxPeople']);

                foreach($areaData['options'] as $opt)
                    $areaObj->addAreaOption($this->getReference("reservationOption_$opt"));

                $this->setReference($areaName, $areaObj);

                $manager->persist($areaObj);
            }
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
        return 50;
    }
}
