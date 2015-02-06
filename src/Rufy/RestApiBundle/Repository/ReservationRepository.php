<?php namespace Rufy\RestApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ReservationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReservationRepository extends EntityRepository
{
    /**
     * Save a Reservation Object
     *
     * @param array $params
     * @return int - generated id
     */
    public function save($params)
    {
        /**
         * Utilizzando $this->getRef() non è più necessario istanziare l'oggetto completo
         * per relazionare un oggetto a un'entità
         */
        //$area           = $this->getRepo('Area')->findOneById($params['area_id']);
        //$user           = $this->getRepo('User')->findOneById(\Auth::user()->getId());
        //$customer       = $this->getRepo('Customer')->findOneById($params['customer_id']);

        $date           = Date::createFromFormat('d/m/Y', $params['date'],'Europe/Rome');
        $time           = Date::createFromFormat('H:i', $params['time'],'Europe/Rome');

        /**
         * TODO
         * Da migliorare: Queste 3 righe  + la riga di setting dell'id permettono di forzare il settaggio dell'id
         * Comodo in fase di test ma da rimuovere in produzione
         */
        $meta = $this->getClassMetadata($this->_class->name);
        $meta->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $meta->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());

        $reservation    = new \Reservation();

        // Leggi sopra
        $reservation->setId($params['id']);

        $reservation->setPeople($params['people']);
        $reservation->setTableName($params['table_name']);
        $reservation->setWaiting($params['waiting']);
        $reservation->setConfirmed($params['confirmed']);

        $reservation->setArea($this->getRef('Area', $params['area_id']));
        $reservation->setUser($this->getRef('User', \Auth::user()->getId()));
        $reservation->setCustomer($this->getRef('Customer', $params['customer_id']));

        $reservation->setDate($date);
        $reservation->setTime($time);

        $this->setTablePosition($reservation, $params);
        $this->setTableDimension($reservation, $params['people']);

        $this->_em->persist($reservation);
        $this->_em->flush();

        return $reservation->getId();
    }

    public function update ($id, $params)
    {
        $reservation = $this->find($id);

        if (!$reservation)
            throw new Exception('Prenotazione non trovata con id '.$id);

        foreach($params as $key => $value) {

            $method = 'set' . ucfirst($key);

            /**
             * TODO
             * Togliere il controllo su XDEBUG?
             */

            if (method_exists($reservation, $method))
                $reservation->$method($value);
            else if ($key != 'XDEBUG_SESSION_START')
                throw new Exception('Setter non valido');
        }

        $this->_em->flush();

        return true;
    }

    /**
     * @param \Reservation $reservation
     * @param int $people
     * @param int $height
     * @return void
     */
    private function setTableDimension(\Reservation $reservation, $people, $height = 1)
    {
        $base = (($people % 2) == 0) ? ($people / 2) - 1 : floor($people / 2) ;

        if (0 >= $base)
            $base = 1;

        if ($height > 1)
            $base -= $height;

        $reservation->setDrawingWidth($base);
        $reservation->setDrawingHeight($height);

        return;
    }

    /**
     * TODO
     * @param \Reservation $reservation
     * @param $params
     */
    private function setTablePosition(\Reservation $reservation, $params) {

        $reservation->setDrawingPosX(20);
        $reservation->setDrawingPosY(30);

        return;
    }

//    /**
//     * @param $name
//     * @param $restaurantId
//     * @param string $surname
//     * @param string $date
//     * @return array
//     */
//    public function findByCustomerName($name, $restaurantId, $surname = '', $date = '')
//    {
//        $date = '' == $date ? Date::now('Europe/Rome')->format('Y-m-d') : Date::createFromFormat('d/m/Y', $date,'Europe/Rome')->format('Y-m-d');
//        //$time = Date::now('Europe/Rome')->format('H:i');
//
//        $q = $this->createQueryBuilder('r')
//            ->select('r', 'c')
//            ->innerJoin('r.customer', 'c')
//            ->where('c.name LIKE :name')
//            ->andWhere('r.date >= :date')
//            ->andWhere('c.restaurant = :restaurant_id')
//            ->setParameter('name', $name)
//            ->setParameter('date', $date)
//            ->setParameter('restaurant_id', $restaurantId)
//            //->andWhere('r.time >= :time')
//            //->setParameter('time', $time)
//        ;
//
//        if ('' != $surname)
//            $q->andWhere('c.surname = :surname')->setParameter('surname', $surname);
//
//        return $q->getQuery()->getResult();
//    }

    public function findByDate($name)
    {

    }

    public function getAll() {

        // TODO
        //Prende solo le prenotazioni del ristorante corrente
    }

    /**
     * Find a reservation by id
     *
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCustom($id)
    {
        //$reservation                = $this->find($id);

        $q = $this->createQueryBuilder('rese')
            ->select('rese, a, c')
            ->leftJoin('rese.area', 'a')
            ->leftJoin('rese.customer', 'c')
            ->where('rese.id = :reservationid')
            ->setParameter('reservationid', $id)
            ->getQuery();

        $reservation = $q->getSingleResult();

        return $reservation;
    }

    /**
     * TODO
     * Implementare limiti - offset - altrei filtri
     *
     * @param $restaurantId
     * @param $limit
     * @param $offset
     * @param $params
     * @return array
     */
    public function findReservations($restaurantId, $limit, $offset, $params)
    {
        $q = $this->createQueryBuilder('rese')
            ->addSelect('a, rest')
            ->leftJoin('rese.area', 'a')
            ->leftJoin('a.restaurant', 'rest')
            ->where('rest.id = :restaurantid')
            ->setParameter('restaurantid', $restaurantId)
            ->getQuery();

        $reservations = $q->getResult();

        return $reservations;
    }
}
