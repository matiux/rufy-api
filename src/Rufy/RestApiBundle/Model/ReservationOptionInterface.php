<?php namespace Rufy\RestApiBundle\Model;

use Rufy\RestApiBundle\Entity\ReservationOption;

interface ReservationOptionInterface
{
    /**
     * Set slug
     *
     * @param string $slug
     * @return ReservationOption
     */
    public function setSlug($slug);

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug();

    /**
     * Add areas
     *
     * @param \Rufy\RestApiBundle\Entity\Area $areas
     * @return ReservationOption
     */
    public function addArea(\Rufy\RestApiBundle\Entity\Area $areas);

    /**
     * Remove areas
     *
     * @param \Rufy\RestApiBundle\Entity\Area $areas
     */
    public function removeArea(\Rufy\RestApiBundle\Entity\Area $areas);

    /**
     * Get areas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAreas();

    /**
     * Add reservations
     *
     * @param \Rufy\RestApiBundle\Entity\Reservation $reservations
     * @return ReservationOption
     */
    public function addReservation(\Rufy\RestApiBundle\Entity\Reservation $reservations);

    /**
     * Remove reservations
     *
     * @param \Rufy\RestApiBundle\Entity\Reservation $reservations
     */
    public function removeReservation(\Rufy\RestApiBundle\Entity\Reservation $reservations);

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservations();
}
