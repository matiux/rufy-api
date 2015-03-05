<?php namespace Rufy\RestApiBundle\Model;

use Rufy\RestApiBundle\Entity\Setting;
use Rufy\RestApiBundle\Entity\CategorySetting;


interface CategorySettingInterface
{
    /**
     * Set name
     *
     * @param string $name
     *
     * @return CategorySetting
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Add setting
     *
     * @param Setting $setting
     *
     * @return CategorySetting
     */
    public function addSetting(Setting $setting);

    /**
     * Remove setting
     *
     * @param Setting $setting
     */
    public function removeSetting(Setting $setting);

    /**
     * Get settings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSettings();
}
