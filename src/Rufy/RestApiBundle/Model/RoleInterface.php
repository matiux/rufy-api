<?php namespace Rufy\RestApiBundle\Model;

use Rufy\RestApiBundle\Entity\Role;

interface RoleInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set name
     *
     * @param string $name
     * @return Role
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set role
     *
     * @param string $role
     * @return Role
     */
    public function setRole($role);

    /**
     * Get role
     *
     * @return string
     */
    public function getRole();

    /**
     * Add users
     *
     * @param \Rufy\RestApiBundle\Entity\User $users
     * @return Role
     */
    public function addUser(\Rufy\RestApiBundle\Entity\User $users);

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

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Role
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
     * @return Role
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
     * @return Role
     */
    public function setDeletedAt($deletedAt);

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt();
}
