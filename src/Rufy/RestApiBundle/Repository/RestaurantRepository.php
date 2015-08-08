<?php namespace Rufy\RestApiBundle\Repository; 

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\ORM\EntityRepository;

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
            ->setParameter('userid', $userId);

        if (0 != $limit) {
            $q = $q->setMaxResults($limit)->setFirstResult($offset);
        }

        $q              = $q->getQuery();
        $restaurants    = $q->getResult();

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
     * @param Area $area
     *
     * @return bool
     */
    public function hasArea(Restaurant $restaurant, Area $area)
    {
        $restaurantAreas = $restaurant->getAreas();

        foreach ($restaurantAreas as $rArea) {

            /**
             * @var $area Area
             */
            if ($rArea->getId() == $area->getId())
                return true;
        }

        return false;
    }

    /**
     * Controlla se un ristorante possiede un determinato Customer
     *
     * @param Customer $customer
     * @param USer $user
     *
     * @return bool
     */
    public function hasCustomer(Customer $customer, User $user)
    {
        // E' un nuovo cliente... E' suo per forza
        if (!$customer->getId()) {
            return true;
        }

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
    }
}
