<?php namespace Rufy\RestApiBundle\Repository; 

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\NoResultException;

use Rufy\RestApiBundle\Entity\Restaurant,
    Rufy\RestApiBundle\Entity\User,
    Rufy\RestApiBundle\Entity\Area,
    Rufy\RestApiBundle\Entity\Customer;

class RestaurantRepository extends EntityRepository
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
        return $this->find($id);
    }

    /**
     * TODO
     * Implementare limit e offset
     *
     * @param $limit
     * @param $offset
     * @param $params
     * @return array
     */
    public function findRestaurants($limit, $offset, $params)
    {
        $userId = $params['userId'];

        $q = $this->createQueryBuilder('r')
            ->leftJoin('r.users', 'u')
            ->where('u.id = :userid')
            ->setParameter('userid', $userId)
            ->getQuery();

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
     *
     * @return bool
     */
    public function hasCustomer(Restaurant $restaurant, Customer $customer)
    {
        $q = $this->createQueryBuilder('r')
            ->select('c.id')
            ->leftJoin('r.customers', 'c')
            ->where('c.id = :customerid')
            ->andWhere('r.id = :restaurantid')
            ->setParameter('customerid', $customer->getId())
            ->setParameter('restaurantid', $restaurant->getId())
            ->getQuery();

        try {

            $customer = $q->getSingleResult();

            return true;

        } catch (NoResultException $e) {

            return false;
        }
    }
}
