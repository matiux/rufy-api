<?php
namespace Rufy\RestApiBundle\Model;

use Rufy\RestApiBundle\Entity\Reservation;
use Rufy\RestApiBundle\Entity\Customer;

interface CustomerInterface
{
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Customer
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Customer
     */
    public function setPhone($phone);

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone();

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail($email);

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set privacy
     *
     * @param boolean $privacy
     *
     * @return Customer
     */
    public function setPrivacy($privacy);

    /**
     * Get privacy
     *
     * @return boolean
     */
    public function getPrivacy();

    /**
     * Set newsletter
     *
     * @param boolean $newsletter
     *
     * @return Customer
     */
    public function setNewsletter($newsletter);

    /**
     * Get newsletter
     *
     * @return boolean
     */
    public function getNewsletter();

    /**
     * Set restaurant
     *
     * @param \Rufy\RestApiBundle\Entity\Restaurant $restaurant
     *
     * @return Customer
     */
    public function setRestaurant(\Rufy\RestApiBundle\Entity\Restaurant $restaurant = null);

    /**
     * Get restaurant
     *
     * @return \Restaurant
     */
    public function getRestaurant();

    /**
     * Add reservation
     *
     * @param Reservation $reservation
     *
     * @return Customer
     */
    public function addReservation(Reservation $reservation);

    /**
     * Remove reservation
     *
     * @param Reservation $reservation
     */
    public function removeReservation(Reservation $reservation);

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservations();
}
