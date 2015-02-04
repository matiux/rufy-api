<?php namespace Rufy\RestApiBundle\Model;

use Rufy\RestApiBundle\Entity\Setting;

interface SettingInterface
{
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Setting
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Setting
     */
    public function setValue($value);

    /**
     * Get value
     *
     * @return string
     */
    public function getValue();

    /**
     * Set restaurant
     *
     * @param \Rufy\RestApiBundle\Entity\Restaurant $restaurant
     *
     * @return Setting
     */
    public function setRestaurant(\Rufy\RestApiBundle\Entity\Restaurant $restaurant = null);

    /**
     * Get restaurant
     *
     * @return \Restaurant
     */
    public function getRestaurant();

    /**
     * Set categorySetting
     *
     * @param \Rufy\RestApiBundle\Entity\CategorySetting $categorySetting
     *
     * @return Setting
     */
    public function setCategorySetting(\Rufy\RestApiBundle\Entity\CategorySetting $categorySetting = null);

    /**
     * Get categorySetting
     *
     * @return \CategorySetting
     */
    public function getCategorySetting();

    /**
     * Set label
     *
     * @param string $label
     *
     * @return Setting
     */
    public function setLabel($label);

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel();

    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Setting
     */
    public function setCreated($created);

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated();

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Setting
     */
    public function setUpdated($updated);

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated();

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Setting
     */
    public function setDeletedAt($deletedAt);

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt();
}
