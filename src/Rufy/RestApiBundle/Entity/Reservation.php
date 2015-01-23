<?php namespace Rufy\RestApiBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Rufy\RestApiBundle\Model\ReservationInterface;

/**
 * @ORM\Entity(repositoryClass="Rufy\RestApiBundle\Entity\ReservationRepository")
 * @ORM\Table(name="reservation", options={"collate"="utf8_general_ci", "charset"="utf8", "engine"="InnoDB"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Reservation implements ReservationInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"unsigned":true, "default":1})
     */
    private $people;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $time;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="boolean", options={"unsigned":true, "default":1}, nullable=false)
     */
    private $confirmed;

    /**
     * @ORM\Column(type="boolean", options={"unsigned":true, "default":0}, nullable=false)
     */
    private $waiting;

    /**
     * @ORM\Column(type="string", nullable=false, unique=false)
     */
    private $table_name;

    /**
     * @ORM\Column(type="smallint", nullable=false, options={"unsigned":true, "default":1})
     */
    private $drawing_width;

    /**
     * @ORM\Column(type="smallint", nullable=false, options={"unsigned":true, "default":1})
     */
    private $drawing_height;

    /**
     * @ORM\Column(type="smallint", nullable=false, options={"unsigned":false})
     */
    private $drawing_pos_x;

    /**
     * @ORM\Column(type="smallint", nullable=false, options={"unsigned":false})
     */
    private $drawing_pos_y;

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
     * @ORM\ManyToOne(targetEntity="Turn", inversedBy="reservations")
     * @ORM\JoinColumn(name="turn_id", referencedColumnName="id", nullable=false)
     */
    private $turn;

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
     * Set confirmed
     *
     * @param boolean $confirmed
     *
     * @return Reservation
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    /**
     * Get confirmed
     *
     * @return boolean
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * Set waiting
     *
     * @param boolean $waiting
     *
     * @return Reservation
     */
    public function setWaiting($waiting)
    {
        $this->waiting = $waiting;

        return $this;
    }

    /**
     * Get waiting
     *
     * @return boolean
     */
    public function getWaiting()
    {
        return $this->waiting;
    }



    /**
     * Set drawingWidth
     *
     * @param integer $drawingWidth
     *
     * @return Reservation
     */
    public function setDrawingWidth($drawingWidth)
    {
        $this->drawing_width = $drawingWidth;

        return $this;
    }

    /**
     * Get drawingWidth
     *
     * @return integer
     */
    public function getDrawingWidth()
    {
        return $this->drawing_width;
    }

    /**
     * Set drawingHeight
     *
     * @param integer $drawingHeight
     *
     * @return Reservation
     */
    public function setDrawingHeight($drawingHeight)
    {
        $this->drawing_height = $drawingHeight;

        return $this;
    }

    /**
     * Get drawingHeight
     *
     * @return integer
     */
    public function getDrawingHeight()
    {
        return $this->drawing_height;
    }

    /**
     * Set drawingPosX
     *
     * @param integer $drawingPosX
     *
     * @return Reservation
     */
    public function setDrawingPosX($drawingPosX)
    {
        $this->drawing_pos_x = $drawingPosX;

        return $this;
    }

    /**
     * Get drawingPosX
     *
     * @return integer
     */
    public function getDrawingPosX()
    {
        return $this->drawing_pos_x;
    }

    /**
     * Set drawingPosY
     *
     * @param integer $drawingPosY
     *
     * @return Reservation
     */
    public function setDrawingPosY($drawingPosY)
    {
        $this->drawing_pos_y = $drawingPosY;

        return $this;
    }

    /**
     * Get drawingPosY
     *
     * @return integer
     */
    public function getDrawingPosY()
    {
        return $this->drawing_pos_y;
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
     * Set turn
     *
     * @param Turn $turn
     *
     * @return Reservation
     */
    public function setTurn(Turn $turn)
    {
        $this->turn = $turn;

        return $this;
    }

    /**
     * Get turn
     *
     * @return \Turn
     */
    public function getTurn()
    {
        return $this->turn;
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
     * @param \DateTime $time
     * @return Reservation
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Reservation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
}
