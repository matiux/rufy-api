<?php namespace Rufy\RestApiBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="setting", options={"collate"="utf8_general_ci", "charset"="utf8", "engine"="InnoDB"})
 */
class Setting
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
    private $name;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $value;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $label;

    /**
     * @ORM\ManyToOne(targetEntity="Restaurant", inversedBy="settings")
     * @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id")
     */
    private $restaurant;

    /**
     * @ORM\ManyToOne(targetEntity="CategorySetting", inversedBy="settings", cascade={"persist"})
     * @ORM\JoinColumn(name="category_setting_id", referencedColumnName="id")
     */
    private $category_setting;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Setting
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
     * Set value
     *
     * @param string $value
     *
     * @return Setting
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set restaurant
     *
     * @param \Restaurant $restaurant
     *
     * @return Setting
     */
    public function setRestaurant(\Restaurant $restaurant = null)
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
     * Set categorySetting
     *
     * @param \CategorySetting $categorySetting
     *
     * @return Setting
     */
    public function setCategorySetting(\CategorySetting $categorySetting = null)
    {
        $this->category_setting = $categorySetting;

        return $this;
    }

    /**
     * Get categorySetting
     *
     * @return \CategorySetting
     */
    public function getCategorySetting()
    {
        return $this->category_setting;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return Setting
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
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
