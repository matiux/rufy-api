<?php namespace Rufy\RestApiBundle\Model;

use Rufy\RestApiBundle\Entity\Role;

interface RoleInterface
{
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
}
