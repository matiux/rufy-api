<?php namespace Rufy\RestApiBundle\Handler; 

//use Doctrine\ORM\EntityManager;
use Rufy\RestApiBundle\Model\ReservationInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ReservationHandler implements ReservationHandlerInterface
{
    //private $_em;
    private $_entityClass;
    private $_repository;

    /**
     * @var ObjectManager
     */
    private $_om;

    public function __construct(ObjectManager $om, $entityClass)
    {
        //$this->_em              = $em;
        $this->_om              = $om;
        $this->_entityClass     = $entityClass;

        $this->_repository      = $this->_om->getRepository($entityClass);
    }

    /**
     * Get a Reservation given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return ReservationInterface
     */
    public function get($id)
    {
        $a = 1;
        return $this->_repository->find($id);
    }

    /**
     * Get a list of Reservations.
     *
     * @param int $limit the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0)
    {
        return $this->_repository->findBy(array(), null, $limit, $offset);
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
        return new $this->entityClass();
    }
}
