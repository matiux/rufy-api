<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Rufy\RestApiBundle\Model\ReservationInterface;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ReservationHandler extends AbstractEntityHandler implements HandlerInterface
{
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
        $reservation = $this->repository->findCustom($id);

        if (false === $this->authChecker->isGranted('VIEW', $reservation)) {
            throw new AccessDeniedException('Accesso non autorizzato!');
        }

        return $reservation;
    }

    /**
     * Get a list of Reservations.
     *
     * @param int $limit            the limit of the result
     * @param int $offset           starting from the offset
     * @param array $params         filter params
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0, $params = array())
    {
        $reservations = $this->repository->findReservations($limit, $offset, $params);

        if (0 < count($reservations))
            if (false === $this->authChecker->isGranted('LISTING', current($reservations)))
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
    public function put($reservation, array $parameters)
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
    public function patch($reservation, array $parameters)
    {
        return $this->processForm($reservation, $parameters, 'PATCH');
    }

    private function createReservation()
    {
        return $this->entityClass;
    }
}
