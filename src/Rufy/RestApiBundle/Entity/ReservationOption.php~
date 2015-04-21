<?php namespace Rufy\RestApiBundle\Entity; 

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\ORM\Mapping AS ORM;

use Gedmo\Mapping\Annotation as Gedmo;

use Rufy\RestApiBundle\Model\ReservationOptionInterface,
    Rufy\RestApiBundle\Model\EntityInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="reservation_option", options={"collate"="utf8_general_ci", "charset"="utf8", "engine"="InnoDB", "comment"="Tabella delle opzioni disponibili da applicare alle sale e di conseguenza alle prenotazioni"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class ReservationOption implements ReservationOptionInterface, EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="Area", mappedBy="areaOptions")
     */
    private $areas;

    /**
     * @ORM\ManyToMany(targetEntity="Reservation", mappedBy="reservationOptions")
     */
    private $reservations;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return ReservationOption
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ReservationOption
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
     * @return ReservationOption
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
     * @return ReservationOption
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
     * Constructor
     */
    public function __construct()
    {
        $this->areas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add areas
     *
     * @param \Rufy\RestApiBundle\Entity\Area $areas
     * @return ReservationOption
     */
    public function addArea(\Rufy\RestApiBundle\Entity\Area $areas)
    {
        $this->areas[] = $areas;

        return $this;
    }

    /**
     * Remove areas
     *
     * @param \Rufy\RestApiBundle\Entity\Area $areas
     */
    public function removeArea(\Rufy\RestApiBundle\Entity\Area $areas)
    {
        $this->areas->removeElement($areas);
    }

    /**
     * Get areas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAreas()
    {
        return $this->areas;
    }

    /**
     * Add reservations
     *
     * @param \Rufy\RestApiBundle\Entity\Reservation $reservations
     * @return ReservationOption
     */
    public function addReservation(\Rufy\RestApiBundle\Entity\Reservation $reservations)
    {
        $this->reservations[] = $reservations;

        return $this;
    }

    /**
     * Remove reservations
     *
     * @param \Rufy\RestApiBundle\Entity\Reservation $reservations
     */
    public function removeReservation(\Rufy\RestApiBundle\Entity\Reservation $reservations)
    {
        $this->reservations->removeElement($reservations);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReservations()
    {
        return $this->reservations;
    }
}
