<?php namespace Rufy\RestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\ORM\Mapping AS ORM;

use Gedmo\Mapping\Annotation as Gedmo;

use Rufy\RestApiBundle\Model\ReservationInterface,
    Rufy\RestApiBundle\Model\EntityInterface;

/**
 * @ORM\Entity(repositoryClass="Rufy\RestApiBundle\Repository\ReservationRepository")
 * @ORM\Table(name="reservation", options={"collate"="utf8_general_ci", "charset"="utf8", "engine"="InnoDB"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks
 */
class Reservation implements ReservationInterface, EntityInterface
{
    public function __construct()
    {
        $this->reservationOptions   = new ArrayCollection();
    }

    //    /**
    //     * @ORM\PrePersist
    //     */
    //    public function onPrePersist()
    //    {
    //        if (is_string($this->time))
    //            $this->time = new \DateTime($this->time);
    //
    //        if (is_string($this->date))
    //            $this->date = new \DateTime($this->date);
    //    }

    /**
     * Reservation ID
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * The number of the people
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true, "default":1})
     */
    private $people;

    /**
     * The number of the extra people
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true, "default":0})
     */
    private $people_extra = 0;

    /**
     * Time to reservation
     * @ORM\Column(type="time", nullable=true)
     */
    private $time;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * The status code:
     * 0 = Waiting list
     * 1 = To confirm
     * 2 = Confirmed
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true, "default":1})
     */
    private $status;

    /**
     * @ORM\Column(type="text", nullable=true, options={"default":""})
     */
    private $note = "";

    /**
     * @ORM\Column(type="string", nullable=false, unique=false)
     */
    private $table_name;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reservations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     **/
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="reservations")
     * @ORM\JoinColumn(name="area_id", referencedColumnName="id", nullable=false)
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="reservations", cascade={"persist"})
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", nullable=false)
     */
    private $customer;

    /**
     * @ORM\ManyToMany(targetEntity="ReservationOption", inversedBy="reservations")
     * @ORM\JoinTable(name="reservations_options")
     */
    private $reservationOptions;

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
     * Set people
     *
     * @param integer $people
     *
     * @return Reservation
     */
    public function setPeople($people)
    {
        $this->people = $people;

        return $this;
    }

    /**
     * Get people
     *
     * @return integer
     */
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Reservation
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set area
     *
     * @param Area $area
     *
     * @return Reservation
     */
    public function setArea(Area $area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return \Area
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set table_name
     *
     * @param string $table_name
     *
     * @return Reservation
     */
    public function setTableName($table_name)
    {
        $this->table_name = $table_name;

        return $this;
    }

    /**
     * Get table_name
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->table_name;
    }

    /**
     * Set customer
     *
     * @param \Rufy\RestApiBundle\Entity\Customer $customer
     *
     * @return Reservation
     */
    public function setCustomer(\Rufy\RestApiBundle\Entity\Customer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Customer
     */
    public function getCustomer()
    {
        return $this->customer;
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
     * @return Reservation
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
     * @return Reservation
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
     * @return Reservation
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
     * Set time
     *
     * To avoid breaking encapsulation
     * http://stackoverflow.com/questions/15486402/doctrine2-orm-does-not-save-changes-to-a-datetime-field/15488230#15488230
     *
     * @param $time
     * @return Reservation
     */
    public function setTime(\DateTime $time = null)
    {
        $this->time = $time ? clone $time : null;

        return $this;
    }

    /**
     * Get time
     *
     * To avoid breaking encapsulation
     * http://stackoverflow.com/questions/15486402/doctrine2-orm-does-not-save-changes-to-a-datetime-field/15488230#15488230
     *
     * @return \DateTime 
     */
    public function getTime()
    {
        $time = $this->time ? clone $this->time : null;

        return $time;
    }

    /**
     * Set date
     *
     * To avoid breaking encapsulation
     * http://stackoverflow.com/questions/15486402/doctrine2-orm-does-not-save-changes-to-a-datetime-field/15488230#15488230
     *
     * @param \DateTime $date
     * @return Reservation
     */
    public function setDate(\DateTime $date = null)
    {
        $this->date = $date ? clone $date : null;

        return $this;
    }

    /**
     * Get date
     *
     * To avoid breaking encapsulation
     * http://stackoverflow.com/questions/15486402/doctrine2-orm-does-not-save-changes-to-a-datetime-field/15488230#15488230
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        $date = $this->date ? clone $this->date : null;

        return $date;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Reservation
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Add reservationOptions
     *
     * @param ReservationOption $reservationOptions
     * @return Reservation
     */
    public function addReservationOption(ReservationOption $reservationOptions)
    {
        $this->reservationOptions[] = $reservationOptions;

        return $this;
    }

    /**
     * Remove reservationOptions
     *
     * @param \Rufy\RestApiBundle\Entity\ReservationOption $reservationOptions
     */
    public function removeReservationOption(\Rufy\RestApiBundle\Entity\ReservationOption $reservationOptions)
    {
        $this->reservationOptions->removeElement($reservationOptions);
    }

    /**
     * Get reservationOptions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReservationOptions()
    {
        return $this->reservationOptions;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Reservation
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set people_extra
     *
     * @param integer $peopleExtra
     *
     * @return Reservation
     */
    public function setPeopleExtra($peopleExtra)
    {
        $this->people_extra = $peopleExtra;

        return $this;
    }

    /**
     * Get people_extra
     *
     * @return integer
     */
    public function getPeopleExtra()
    {
        return $this->people_extra;
    }

//    public static function getReservationOptions2()
//    {
//        return array(1, 2);
//    }
}
