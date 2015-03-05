<?php namespace Rufy\RestApiBundle\Model;

interface OwnerInterface
{
    /**
     * Set name
     *
     * @param string $name
     * @return \Rufy\RestApiBundle\Entity\Owner
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set surname
     *
     * @param string $surname
     * @return \Rufy\RestApiBundle\Entity\Owner
     */
    public function setSurname($surname);

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname();

    /**
     * Set email
     *
     * @param string $email
     * @return \Rufy\RestApiBundle\Entity\Owner
     */
    public function setEmail($email);

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set phone
     *
     * @param string $phone
     * @return \Rufy\RestApiBundle\Entity\Owner
     */
    public function setPhone($phone);

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone();

    /**
     * Set active
     *
     * @param boolean $active
     * @return \Rufy\RestApiBundle\Entity\Owner
     */
    public function setActive($active);

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive();

    /**
     * Add users
     *
     * @param \Rufy\RestApiBundle\Entity\User $user
     * @return \Rufy\RestApiBundle\Entity\Owner
     */
    public function addUser(\Rufy\RestApiBundle\Entity\User $user);

    /**
     * Remove users
     *
     * @param \Rufy\RestApiBundle\Entity\User $users
     */
    public function removeUser(\Rufy\RestApiBundle\Entity\User $users);

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers();
}
