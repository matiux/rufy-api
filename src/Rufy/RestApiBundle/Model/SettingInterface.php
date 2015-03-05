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
}
