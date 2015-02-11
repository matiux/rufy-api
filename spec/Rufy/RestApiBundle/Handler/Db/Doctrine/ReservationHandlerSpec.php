<?php

namespace spec\Rufy\RestApiBundle\Handler\Db\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Rufy\RestApiBundle\Entity\Reservation;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage,
    Symfony\Component\Security\Core\Authorization\AuthorizationChecker;


class ReservationHandlerSpec extends ObjectBehavior
{
    protected $om;
    protected $repository;

    function it_is_initializable()
    {
        $this->shouldHaveType('Rufy\RestApiBundle\Handler\Db\Doctrine\ReservationHandler');
    }

//    function let(ObjectManager $om, TokenStorage $tokenStorage, AuthorizationChecker $authChecker, Reservation $reservationEntity)
//    {
//        //$this->beConstructedWith();
//
//        $om->getRepository(get_class($reservationEntity))->willReturn(new Reservation());
////        $this->setUser($tokenStorage);
////        $this->setAuthorizationChecker($authChecker);
//        $this->setEntityClass($reservationEntity);
//    }

    function it_get_a_single_reservation($repository)
    {
        $repository->beADoubleOf('Rufy\RestApiBundle\Repository\ReservationRepository');

        $this->repository->findCustom()->willReturn(new Reservation());

        $reservationId = 1;

        $this->get($reservationId)->shouldReturn('a');

        //$this->testPhpSpec($reservationId)->shouldReturn("Id: $reservationId");
    }
}
