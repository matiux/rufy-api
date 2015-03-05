<?php namespace Rufy\RestApiBundle\Model;

use Rufy\RestApiBundle\Entity\Restaurant;

interface RestaurantInterface
{
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Restaurant
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set restDate
     *
     * @param integer $restDate
     *
     * @return Restaurant
     */
    public function setRestDate($restDate);

    /**
     * Get restDate
     *
     * @return integer
     */
    public function getRestDate();

    /**
     * Add user
     *
     * @param \Rufy\RestApiBundle\Entity\User $user
     *
     * @return Restaurant
     */
    public function addUser(\Rufy\RestApiBundle\Entity\User $user);

    /**
     * Remove user
     *
     * @param \Rufy\RestApiBundle\Entity\User $user
     */
    public function removeUser(\Rufy\RestApiBundle\Entity\User $user);

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers();

    /**
     * Add area
     *
     * @param \Rufy\RestApiBundle\Entity\Area $area
     *
     * @return Restaurant
     */
    public function addArea(\Rufy\RestApiBundle\Entity\Area $area);

    /**
     * Remove area
     *
     * @param \Rufy\RestApiBundle\Entity\Area $area
     */
    public function removeArea(\Rufy\RestApiBundle\Entity\Area $area);

    /**
     * Get areas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAreas();

    /**
     * Set customer
     *
     * @param \Rufy\RestApiBundle\Entity\Customer $customer
     *
     * @return Restaurant
     */
    public function setCustomer(\Rufy\RestApiBundle\Entity\Customer $customer);

    /**
     * Add setting
     *
     * @param \Rufy\RestApiBundle\Entity\Setting $setting
     *
     * @return Restaurant
     */
    public function addSetting(\Rufy\RestApiBundle\Entity\Setting $setting);

    /**
     * Remove setting
     *
     * @param \Rufy\RestApiBundle\Entity\Setting $setting
     */
    public function removeSetting(\Rufy\RestApiBundle\Entity\Setting $setting);

    /**
     * Get settings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSettings();

    /**
     * Add customer
     *
     * @param \Rufy\RestApiBundle\Entity\Customer $customer
     *
     * @return Restaurant
     */
    public function addCustomer(\Rufy\RestApiBundle\Entity\Customer $customer);

    /**
     * Remove customer
     *
     * @param \Rufy\RestApiBundle\Entity\Customer $customer
     */
    public function removeCustomer(\Rufy\RestApiBundle\Entity\Customer $customer);

    /**
     * Get customers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCustomers();
}
