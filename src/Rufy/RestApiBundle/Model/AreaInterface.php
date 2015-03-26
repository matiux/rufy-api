<?php namespace Rufy\RestApiBundle\Model;

use Rufy\RestApiBundle\Entity\Area,
    Rufy\RestApiBundle\Entity\Reservation,
    Rufy\RestApiBundle\Entity\Restaurant;

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
     * @param Restaurant $restaurant
     *
     * @return Area
     */
    public function setRestaurant(Restaurant $restaurant);

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
