<?php namespace Rufy\RestApiBundle\Model;

use Rufy\RestApiBundle\Entity\Role;
use Rufy\RestApiBundle\Entity\User;

interface UserInterface
{
    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username);

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername();

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive);

    /**
     * Get is_active
     *
     * @return boolean
     */
    public function getIsActive();

    /**
     * Set owner
     *
     * @param \Rufy\RestApiBundle\Entity\Owner $owner
     * @return User
     */
    public function setOwner(\Rufy\RestApiBundle\Entity\Owner $owner = null);

    /**
     * Get owner
     *
     * @return \Rufy\RestApiBundle\Entity\Owner
     */
    public function getOwner();

    /**
     * Add restaurants
     *
     * @param \Rufy\RestApiBundle\Entity\Restaurant $restaurants
     * @return User
     */
    public function addRestaurant(\Rufy\RestApiBundle\Entity\Restaurant $restaurants);

    /**
     * Remove restaurants
     *
     * @param \Rufy\RestApiBundle\Entity\Restaurant $restaurants
     */
    public function removeRestaurant(\Rufy\RestApiBundle\Entity\Restaurant $restaurants);

    /**
     * Get restaurants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRestaurants();

    /**
     * Add reservations
     *
     * @param \Rufy\RestApiBundle\Entity\Reservation $reservations
     * @return User
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

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize();

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized);

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles();

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword();

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt();

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials();

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password);

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired();

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked();

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired();

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled();

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email);

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Add roles
     *
     * @param \Rufy\RestApiBundle\Entity\Role $roles
     * @return User
     */
    public function addRole(\Rufy\RestApiBundle\Entity\Role $roles);

    /**
     * Remove roles
     *
     * @param \Rufy\RestApiBundle\Entity\Role $roles
     */
    public function removeRole(\Rufy\RestApiBundle\Entity\Role $roles);
}
