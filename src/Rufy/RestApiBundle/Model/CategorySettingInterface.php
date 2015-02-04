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
     * @return CategorySetting
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
     * @return CategorySetting
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
     * @return CategorySetting
     */
    public function setDeletedAt($deletedAt);

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt();
}
