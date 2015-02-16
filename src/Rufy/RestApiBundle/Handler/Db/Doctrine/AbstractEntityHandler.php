<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;

use Rufy\RestApiBundle\Entity\Reservation,
    Rufy\RestApiBundle\Entity\Restaurant,
    Rufy\RestApiBundle\Repository\ReservationRepository,
    Rufy\RestApiBundle\Repository\RestaurantRepository,
    Rufy\RestApiBundle\Repository\UserRepository;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage,
    Symfony\Component\Security\Core\Authorization\AuthorizationChecker,
    Symfony\Component\Form\FormFactory;

abstract class AbstractEntityHandler
{
    /**
     * @var Reservation|Restaurant
     */
    protected $entityClass;

    /**
     * @var ReservationRepository|RestaurantRepository
     */
    protected $repository;

    /**
     * @var ObjectManager
     */
    protected $om;

    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * @var SecurityContextInterface
     */
    protected $authChecker;

    /**
     * @var FormFactory
     */
    protected $formFactory;

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

    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
    }

    protected function createResource()
    {
        return new $this->entityClass();
    }
}
