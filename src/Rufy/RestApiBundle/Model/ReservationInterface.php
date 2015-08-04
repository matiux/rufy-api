<?php namespace Rufy\RestApiBundle\Model;

use Rufy\RestApiBundle\Entity\User,
    Rufy\RestApiBundle\Entity\Area,
    Rufy\RestApiBundle\Entity\Customer;

interface ReservationInterface {

    public function setPeople($people);
    public function getPeople();
    public function setTime(\DateTime $time);
    public function getTime();
    public function setDate(\DateTime $date);
    public function getDate();
    public function setStatus($confirmed);
    public function getStatus();
    public function setUser(User $user);
    public function getUser();
    public function setArea(Area $area);
    public function getArea();
    public function setTableName($table_name);
    public function getTableName();
    public function setCustomer(Customer $customer);
    public function getCustomer();
}
