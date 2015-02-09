<?php namespace Rufy\RestApiBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Rufy\RestApiBundle\Model\AreaInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="area", options={"collate"="utf8_general_ci", "charset"="utf8", "engine"="InnoDB"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Area implements AreaInterface
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
     * @ORM\Column(type="boolean", options={"default":0})
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
     * @ORM\ManyToMany(targetEntity="ReservationOption", inversedBy="areas")
     * @ORM\JoinTable(name="areas_options")
     */
    private $areaOptions;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

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
     * @param Reservation $reservations
     *
     * @return Area
     */
    public function setReservations(Reservation $reservations)
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
     * @param Reservation $reservation
     *
     * @return Area
     */
    public function addReservation(Reservation $reservation)
    {
        $this->reservations[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation
     *
     * @param Reservation $reservation
     */
    public function removeReservation(Reservation $reservation)
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

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Area
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Area
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Area
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Add areaOptions
     *
     * @param \Rufy\RestApiBundle\Entity\ReservationOption $areaOptions
     * @return Area
     */
    public function addAreaOption(\Rufy\RestApiBundle\Entity\ReservationOption $areaOptions)
    {
        $this->areaOptions[] = $areaOptions;

        return $this;
    }

    /**
     * Remove areaOptions
     *
     * @param \Rufy\RestApiBundle\Entity\ReservationOption $areaOptions
     */
    public function removeAreaOption(\Rufy\RestApiBundle\Entity\ReservationOption $areaOptions)
    {
        $this->areaOptions->removeElement($areaOptions);
    }

    /**
     * Get areaOptions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAreaOptions()
    {
        return $this->areaOptions;
    }
}
