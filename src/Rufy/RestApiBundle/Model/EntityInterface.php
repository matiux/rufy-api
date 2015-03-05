<?php namespace Rufy\RestApiBundle\Model;

interface EntityInterface {

    public function getId();
    public function setCreated($created);
    public function getCreated();
    public function setUpdated($updated);
    public function getUpdated();
    public function setDeletedAt($deletedAt);
    public function getDeletedAt();

}
