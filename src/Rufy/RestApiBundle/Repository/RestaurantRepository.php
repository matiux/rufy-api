<?php namespace Rufy\RestApiBundle\Repository; 

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\ORM\EntityRepository,
    Doctrine\ORM\NoResultException;

use Rufy\RestApiBundle\Entity\Restaurant,
    Rufy\RestApiBundle\Entity\User,
    Rufy\RestApiBundle\Entity\Area,
    Rufy\RestApiBundle\Entity\Customer;

class RestaurantRepository extends EntityRepository implements EntityRepositoryInterface
{
    /**
     * Find a restaurant by id
     *
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCustom($id)
    {
        $restaurant = $this->find($id);

        return $restaurant;
    }

    /**
     * {@inheritdoc }
     */
    public function findMore($limit, $offset, $params, $filters = array())
    {
        $userId = $params['userId'];

        $q = $this->createQueryBuilder('r')
            ->join('r.users', 'u')
            ->where('u.id = :userid')
            ->setParameter('userid', $userId)
            ->getQuery()
            ->setMaxResults($limit)
            ->setFirstResult($offset);

        $restaurants = $q->getResult();

        return $restaurants;
    }

    public function hasUser(Restaurant $restaurant, User $user)
    {
        //$restaurant         = is_array($restaurant) ? current($restaurant) : $restaurant;
        $restaurantUsers    = $restaurant->getUsers();

        if ($restaurantUsers)
            foreach ($restaurantUsers as $restaurantUser)
                if ($restaurantUser->getId() == $user->getId())
                    return true;

        return false;
    }

    /**
     * Controlla se un ristorante possiede una determinata area
     *
     * @param Restaurant $restaurant
     * @param Area $reservationArea
     *
     * @return bool
     */
    public function hasArea(Restaurant $restaurant, Area $reservationArea)
    {
        $restaurantAreas = $restaurant->getAreas();

        foreach ($restaurantAreas as $area) {

            /**
             * @var $area Area
             */
            if ($area->getId() == $reservationArea->getId())
                return true;
        }

        return false;
    }

    /**
     * Controlla se un ristorante possiede un determinato Customer
     *
     * @param Restaurant $restaurant
     * @param Customer $customer
     * @param USer $user
     *
     * @return bool
     */
    public function hasCustomer(Restaurant $restaurant, Customer $customer, User $user)
    {
        /**
         * "Restaurant $restaurant" non è più in uso da quando ho sotituito il controllo sul db con
         * il codice attuale che si basa sui dati già presi dall'autenticazione. Vedi anche:
         * Rufy/RestApiBundle/Security/Authorization/Voter/ReservationVoter.php
         */

        $customers = $user->getRestaurants()->map(function($r) use ($customer) {

            /**
             * Passando per il repository Customer piuttosto che ricavare i customers da $r->getCustomers(); mi da modo di avere
             * la lista dei Customers aggiornata. Questo è necessario nel caso in cui si salvi una prenotazione con un nuovo Customer
             * dato che dopo il salvataggio del Customer, la collection in $r->getCustomers(); non è aggiornata
             *
             * @var $customersUpdated ArrayCollection
             */

            $customersUpdated = new ArrayCollection($this->_em->getRepository('RufyRestApiBundle:Customer')->findBy(['restaurant' => $r->getId()]));

            return $customersUpdated->contains($customer);

        })->exists(function($key, $value) {

            return $value == true;
        });

        return $customers ? true : false;

//        $q = $this->createQueryBuilder('r')
//            ->select('c.id')
//            ->join('r.customers', 'c')
//            ->where('c.id = :customerid')
//            ->andWhere('r.id = :restaurantid')
//            ->setParameter('customerid', $customer->getId())
//            ->setParameter('restaurantid', $restaurant->getId())
//            ->getQuery();
//
//        try {
//
//            $customer = $q->getSingleResult();
//
//            return true;
//
//        } catch (NoResultException $e) {
//
//            return false;
//        }
    }
}
