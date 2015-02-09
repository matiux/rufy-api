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

    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Area
     */
    public function setCreated($created);

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated();

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Area
     */
    public function setUpdated($updated);

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated();

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Area
     */
    public function setDeletedAt($deletedAt);

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt();
}
