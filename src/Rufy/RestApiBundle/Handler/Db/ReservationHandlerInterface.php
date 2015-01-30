<?php namespace Rufy\RestApiBundle\Handler\Db;

use Rufy\RestApiBundle\Model\ReservationInterface;

interface ReservationHandlerInterface
{
    /**
     * Get a Reservation given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return ReservationInterface
     */
    public function get($id);
    /**
     * Get a list of Reservations.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);
    /**
     * Post Reservation, creates a new Reservation.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return ReservationInterface
     */
    public function post(array $parameters);

    /**
     * Edit a Reservation.
     *
     * @api
     *
     * @param ReservationInterface   $reservation
     * @param array           $parameters
     *
     * @return ReservationInterface
     */
    public function put(ReservationInterface $reservation, array $parameters);

    /**
     * Partially update a Reservation.
     *
     * @api
     *
     * @param ReservationInterface   $reservation
     * @param array           $parameters
     *
     * @return ReservationInterface
     */
    public function patch(ReservationInterface $reservation, array $parameters);
}
