<?php namespace Rufy\RestApiBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="restaurant", options={"collate"="utf8_general_ci", "charset"="utf8", "engine"="InnoDB"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Restaurant {

    public function __construct() {

        $this->users            = new ArrayCollection();
        $this->services         = new ArrayCollection();
        $this->settings         = new ArrayCollection();
        $this->customers        = new ArrayCollection();
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
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $rest_date;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="restaurants")
     **/
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="Area", mappedBy="restaurant", cascade={"persist","remove"})
     */
    private $areas;

    /**
     * @ORM\OneToMany(targetEntity="Customer", mappedBy="restaurant")
     **/
    private $customers;

    /**
     * @ORM\OneToMany(targetEntity="Service", mappedBy="restaurant", cascade={"persist"})
     */
    private $services;

    /**
     * @ORM\OneToMany(targetEntity="Setting", mappedBy="restaurant", cascade={"remove"})
     */
    private $settings;

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
     * @return Restaurant
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
     * Set restDate
     *
     * @param integer $restDate
     *
     * @return Restaurant
     */
    public function setRestDate($restDate)
    {
        $this->rest_date = $restDate;

        return $this;
    }

    /**
     * Get restDate
     *
     * @return integer
     */
    public function getRestDate()
    {
        return $this->rest_date;
    }

    /**
     * Add user
     *
     * @param \User $user
     *
     * @return Restaurant
     */
    public function addUser(\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \User $user
     */
    public function removeUser(\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add area
     *
     * @param \Rufy\RestApiBundle\Entity\Area $area
     *
     * @return Restaurant
     */
    public function addArea(\Rufy\RestApiBundle\Entity\Area $area)
    {
        $this->areas[] = $area;

        return $this;
    }

    /**
     * Remove area
     *
     * @param \Area $area
     */
    public function removeArea(\Area $area)
    {
        $this->areas->removeElement($area);
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
     * Set customer
     *
     * @param \Customer $customer
     *
     * @return Restaurant
     */
    public function setCustomer(\Customer $customer)
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
     * Add service
     *
     * @param \Rufy\RestApiBundle\Entity\Service
     *
     * @return Restaurant
     */
    public function addService(\Rufy\RestApiBundle\Entity\Service $service)
    {
        $this->services[] = $service;

        $service->setRestaurant($this);

        return $this;
    }

    /**
     * Remove service
     *
     * @param \Service $service
     */
    public function removeService(\Service $service)
    {
        $this->services->removeElement($service);
    }

    /**
     * Get services
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Add setting
     *
     * @param \Setting $setting
     *
     * @return Restaurant
     */
    public function addSetting(\Setting $setting)
    {
        $this->settings[] = $setting;

        return $this;
    }

    /**
     * Remove setting
     *
     * @param \Setting $setting
     */
    public function removeSetting(\Setting $setting)
    {
        $this->settings->removeElement($setting);
    }

    /**
     * Get settings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Add customer
     *
     * @param \Customer $customer
     *
     * @return Restaurant
     */
    public function addCustomer(\Customer $customer)
    {
        $this->customers[] = $customer;

        return $this;
    }

    /**
     * Remove customer
     *
     * @param \Customer $customer
     */
    public function removeCustomer(\Customer $customer)
    {
        $this->customers->removeElement($customer);
    }

    /**
     * Get customers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCustomers()
    {
        return $this->customers;
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
     * @return Restaurant
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
     * @return Restaurant
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
     * @return Restaurant
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
}
