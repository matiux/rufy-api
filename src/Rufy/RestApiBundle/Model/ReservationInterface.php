<?php namespace Rufy\RestApiBundle\Model;

use Rufy\RestApiBundle\Entity\User;
use Rufy\RestApiBundle\Entity\Area;
use Rufy\RestApiBundle\Entity\Customer;
use Rufy\RestApiBundle\Entity\Turn;

interface ReservationInterface {

    public function setPeople($people);
    public function getPeople();
    public function setTime($time);
    public function getTime();
    public function setDate($date);
    public function getDate();
    public function setConfirmed($confirmed);
    public function getConfirmed();
    public function setWaiting($waiting);
    public function getWaiting();
    public function setDrawingWidth($drawingWidth);
    public function getDrawingWidth();
    public function setDrawingHeight($drawingHeight);
    public function getDrawingHeight();
    public function setDrawingPosX($drawingPosX);
    public function getDrawingPosX();
    public function setDrawingPosY($drawingPosY);
    public function getDrawingPosY();
    public function setUser(User $user);
    public function getUser();
    public function setArea(Area $area);
    public function getArea();
    public function setTableName($table_name);
    public function getTableName();
    public function setCustomer(Customer $customer);
    public function getCustomer();
    public function setTurn(Turn $turn);
    public function getTurn();
    public function getId();
    public function setCreated($created);
    public function getCreated();
    public function setUpdated($updated);
    public function getUpdated();
    public function setDeletedAt($deletedAt);
    public function getDeletedAt();
}
