<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Rufy\RestApiBundle\Entity\Reservation,
    Rufy\RestApiBundle\Model\ReservationInterface,
    Rufy\RestApiBundle\Handler\Db\HandlerDbInterface\ReservationHandlerInterface;

use Doctrine\Common\Persistence\ObjectManager,
    Doctrine\ORM\NoResultException;

use Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage,
    Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class ReservationHandler implements ReservationHandlerInterface
{
    /**
     * @var \Rufy\RestApiBundle\Entity\Reservation
     */
    private $_reservationClass;

    /**
     * @var \Rufy\RestApiBundle\Repository\ReservationRepository
     */
    private $_repository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $_om;

    /**
     * @var \Rufy\RestApiBundle\Repository\UserRepository
     */
    private $_user;

    /**
     * @var SecurityContextInterface
     */
    private $_authChecker;

    public function __construct(ObjectManager $om, Reservation $entityClass, TokenStorage $tokenStorage, AuthorizationChecker $authChecker)
    {
        $this->_om                      = $om;
        $this->_reservationClass        = $entityClass;
        $this->_authChecker             = $authChecker;
        $this->_user                    = $tokenStorage->getToken()->getUser();

        $this->_repository              = $this->_om->getRepository(get_class($entityClass));
    }

    /**
     * Get a Reservation given the identifier and checking that the reservation belongs to the user who invokes
     *
     * @api
     *
     * @param int $id - Reservation ID
     *
     * @return ReservationInterface
     * @return null
     *
     * @throws AccessDeniedException
     */
    public function get($id)
    {
        $reservation = $this->_repository->findCustom($id);

        if (false === $this->_authChecker->isGranted('view', $reservation)) {
            throw new AccessDeniedException('Accesso non autorizzato!');
        }

        return $reservation;
    }

    /**
     * Get a list of Reservations.
     *
     * @param int $restaurantId     the restaurant's id
     * @param int $limit            the limit of the result
     * @param int $offset           starting from the offset
     * @param array $params         filter params
     *
     * @return array
     */
    public function all($restaurantId, $limit = 5, $offset = 0, $params = array())
    {
        $reservations = $this->_repository->findReservations($restaurantId, $limit, $offset, $params);

        if (0 < count($reservations))
            if (false === $this->_authChecker->isGranted('listing', current($reservations)))
                throw new AccessDeniedException('Accesso non autorizzato!');

        return $reservations;
    }

    /**
     * Post Reservation, creates a new Reservation.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return ReservationInterface
     */
    public function post(array $parameters)
    {
        $reservation = $this->createReservation();

        return $this->processForm($reservation, $parameters, 'POST');
    }

    /**
     * Edit a Reservation.
     *
     * @api
     *
     * @param ReservationInterface $reservation
     * @param array $parameters
     *
     * @return ReservationInterface
     */
    public function put(ReservationInterface $reservation, array $parameters)
    {
        return $this->processForm($reservation, $parameters, 'PUT');
    }

    /**
     * Partially update a Reservation.
     *
     * @api
     *
     * @param ReservationInterface $reservation
     * @param array $parameters
     *
     * @return ReservationInterface
     */
    public function patch(ReservationInterface $reservation, array $parameters)
    {
        return $this->processForm($reservation, $parameters, 'PATCH');
    }

    private function createReservation()
    {
        return $this->entityClass;
    }
}
