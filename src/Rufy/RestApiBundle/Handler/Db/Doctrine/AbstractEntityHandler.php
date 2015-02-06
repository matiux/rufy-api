<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Doctrine\Common\Persistence\ObjectManager,
    Doctrine\ORM\NoResultException;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage,
    Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

abstract class AbstractEntityHandler
{
    /**
     * @var \Rufy\RestApiBundle\Entity\Reservation
     */
    protected $entityClass;

    /**
     * @var \Rufy\RestApiBundle\Repository\ReservationRepository
     * @var \Rufy\RestApiBundle\Repository\RestaurantRepository
     */
    protected $repository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $om;

    /**
     * @var \Rufy\RestApiBundle\Repository\UserRepository
     */
    protected $user;

    /**
     * @var SecurityContextInterface
     */
    protected $authChecker;

    public function setEntityClass($entityClass)
    {
        $this->entityClass              = $entityClass;
        $this->repository               = $this->om->getRepository(get_class($entityClass));
    }

    public function setObjectManagerAndEntity(ObjectManager $om)
    {
        $this->om                       = $om;
    }

    public function setUser(TokenStorage $tokenStorage)
    {
        $this->user                     = $tokenStorage->getToken()->getUser();
    }

    public function setAuthorizationChecker(AuthorizationChecker $authChecker)
    {
        $this->authChecker              = $authChecker;
    }
}
