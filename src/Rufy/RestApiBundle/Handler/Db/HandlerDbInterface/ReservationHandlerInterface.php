<?php namespace Rufy\RestApiBundle\Handler\Db\HandlerDbInterface;

use Rufy\RestApiBundle\Model\ReservationInterface;

interface ReservationHandlerInterface
{
    /**
     * Get a Reservation given the identifier
     *
     * @api
     *
     * @param int $id
     *
     * @return ReservationInterface
     */
    public function get($id);
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
    public function all($restaurantId, $limit = 5, $offset = 0, $params = array());
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
