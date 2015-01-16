<?php namespace Rufy\RestApiBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="area", options={"collate"="utf8_general_ci", "charset"="utf8", "engine"="InnoDB"})
 */
class Area
{
    public function __construct() {

        $this->reservations           = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", options={"unsigned":true, "default":0})
     */
    private $outside;

    /**
     * @ORM\Column(type="boolean", options={"unsigned":true, "default":0})
     */
    private $smokers;

    /**
     * @ORM\Column(type="boolean", options={"unsigned":true, "default":0})
     */
    private $invalids;

    /**
     * @ORM\Column(type="boolean", options={"unsigned":true, "default":0})
     */
    private $animals;

    /**
     * @ORM\Column(type="boolean", options={"unsigned":true, "default":0})
     */
    private $full;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurant", inversedBy="areas", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id", nullable=false)
     */
    private $restaurant;

    /**
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="area", cascade={"remove"})
     */
    private $reservations;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Area
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set outside
     *
     * @param boolean $outside
     *
     * @return Area
     */
    public function setOutside($outside)
    {
        $this->outside = $outside;

        return $this;
    }

    /**
     * Get outside
     *
     * @return boolean
     */
    public function getOutside()
    {
        return $this->outside;
    }

    /**
     * Set smokers
     *
     * @param boolean $smokers
     *
     * @return Area
     */
    public function setSmokers($smokers)
    {
        $this->smokers = $smokers;

        return $this;
    }

    /**
     * Get smokers
     *
     * @return boolean
     */
    public function getSmokers()
    {
        return $this->smokers;
    }

    /**
     * Set invalids
     *
     * @param boolean $invalids
     *
     * @return Area
     */
    public function setInvalids($invalids)
    {
        $this->invalids = $invalids;

        return $this;
    }

    /**
     * Get invalids
     *
     * @return boolean
     */
    public function getInvalids()
    {
        return $this->invalids;
    }

    /**
     * Set animals
     *
     * @param boolean $animals
     *
     * @return Area
     */
    public function setAnimals($animals)
    {
        $this->animals = $animals;

        return $this;
    }

    /**
     * Get animals
     *
     * @return boolean
     */
    public function getAnimals()
    {
        return $this->animals;
    }

    /**
     * Set full
     *
     * @param boolean $full
     *
     * @return Area
     */
    public function setFull($full)
    {
        $this->full = $full;

        return $this;
    }

    /**
     * Get full
     *
     * @return boolean
     */
    public function getFull()
    {
        return $this->full;
    }

    /**
     * Set restaurant
     *
     * @param \Rufy\RestApiBundle\Entity\Restaurant $restaurant
     *
     * @return Area
     */
    public function setRestaurant(\Rufy\RestApiBundle\Entity\Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * Get restaurant
     *
     * @return \Restaurant
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }

    /**
     * Set reservations
     *
     * @param \Reservation $reservations
     *
     * @return Area
     */
    public function setReservations(\Reservation $reservations)
    {
        $this->reservations = $reservations;

        return $this;
    }

    /**
     * Get reservations
     *
     * @return \Reservation
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * Add reservation
     *
     * @param \Reservation $reservation
     *
     * @return Area
     */
    public function addReservation(\Reservation $reservation)
    {
        $this->reservations[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation
     *
     * @param \Reservation $reservation
     */
    public function removeReservation(\Reservation $reservation)
    {
        $this->reservations->removeElement($reservation);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
