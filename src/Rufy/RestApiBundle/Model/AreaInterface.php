<?php namespace Rufy\RestApiBundle\Model;

use Rufy\RestApiBundle\Entity\Area;
use Rufy\RestApiBundle\Entity\Reservation;

interface AreaInterface
{
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Area
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set restaurant
     *
     * @param \Rufy\RestApiBundle\Entity\Restaurant $restaurant
     *
     * @return Area
     */
    public function setRestaurant(\Rufy\RestApiBundle\Entity\Restaurant $restaurant);

    /**
     * Get restaurant
     *
     * @return \Restaurant
     */
    public function getRestaurant();

    /**
     * Set reservations
     *
     * @param Reservation $reservations
     *
     * @return Area
     */
    public function setReservations(Reservation $reservations);

    /**
     * Get reservations
     *
     * @return \Reservation
     */
    public function getReservations();

    /**
     * Add reservation
     *
     * @param Reservation $reservation
     *
     * @return Area
     */
    public function addReservation(Reservation $reservation);

    /**
     * Remove reservation
     *
     * @param Reservation $reservation
     */
    public function removeReservation(Reservation $reservation);
}
