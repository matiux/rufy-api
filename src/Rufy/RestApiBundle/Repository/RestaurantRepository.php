<?php namespace Rufy\RestApiBundle\Repository; 

use Doctrine\ORM\EntityRepository;

use Rufy\RestApiBundle\Entity\Restaurant;
use Rufy\RestApiBundle\Entity\User;

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
        $restaurantUsers = $restaurant->getUsers();

        if ($restaurantUsers) {

            foreach ($restaurantUsers as $restaurantUser) {

                if ($restaurantUser->getId() == $user->getId())
                    return true;
            }
        }

        return false;
    }
}
