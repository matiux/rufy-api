<?php namespace Rufy\RestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\ORM\Mapping AS ORM;

use Gedmo\Mapping\Annotation as Gedmo;

use Rufy\RestApiBundle\Model\AreaInterface,
    Rufy\RestApiBundle\Model\EntityInterface;

/**
 * @ORM\Entity(repositoryClass="Rufy\RestApiBundle\Repository\AreaRepository")
 * @ORM\Table(name="area", options={"collate"="utf8_general_ci", "charset"="utf8", "engine"="InnoDB"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Area implements AreaInterface, EntityInterface
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
     * The number of the people
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true, "default":1})
     */
    private $maxPeople = 1;

    /**
     * The maximum number of people per table
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true, "default":1})
     */
    private $maxPeopleTable = 1;

    /**
     * The minimum number of people per table
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true, "default":1})
     */
    private $minPeopleTable = 2;

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

    public function getRestaurantId()
    {
        return $this->restaurant->getId();
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

    /**
     * Set maxPeople
     *
     * @param integer $maxPeople
     *
     * @return Area
     */
    public function setMaxPeople($maxPeople)
    {
        $this->maxPeople = $maxPeople;

        return $this;
    }

    /**
     * Get maxPeople
     *
     * @return integer
     */
    public function getMaxPeople()
    {
        return $this->maxPeople;
    }

    /**
     * Set maxPeopleTable
     *
     * @param integer $maxPeopleTable
     *
     * @return Area
     */
    public function setMaxPeopleTale($maxPeopleTable)
    {
        $this->maxPeopleTable = $maxPeopleTable;

        return $this;
    }

    /**
     * Get maxPeopleTable
     *
     * @return integer
     */
    public function getMaxPeopleTable()
    {
        return $this->maxPeopleTable;
    }

    /**
     * Set minPeopleTable
     *
     * @param integer $minPeopleTable
     *
     * @return Area
     */
    public function setMinPeopleTale($minPeopleTable)
    {
        $this->minPeopleTable = $minPeopleTable;

        return $this;
    }

    /**
     * Get minPeopleTable
     *
     * @return integer
     */
    public function getMinPeopleTable()
    {
        return $this->minPeopleTable;
    }
}
