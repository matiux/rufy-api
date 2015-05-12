<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;

use Rufy\RestApiBundle\Entity\Reservation,
    Rufy\RestApiBundle\Entity\Restaurant,
    Rufy\RestApiBundle\Repository\ReservationRepository,
    Rufy\RestApiBundle\Repository\RestaurantRepository,
    Rufy\RestApiBundle\Repository\UserRepository,
    Rufy\RestApiBundle\Model\EntityInterface;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface,
    Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface,
    Symfony\Component\Form\FormFactoryInterface,
    Symfony\Component\Form\FormFactory,
    Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

    public function setEntityClass(EntityInterface $entityClass)
    {
        $this->entityClass              = $entityClass;
        $this->repository               = $this->om->getRepository(get_class($entityClass));
    }

    public function setObjectManagerAndEntity(ObjectManager $om)
    {
        $this->om                       = $om;
    }

    public function setUser(TokenStorageInterface $tokenStorage)
    {
        $this->user                     = $tokenStorage->getToken()->getUser();
    }

    public function setAuthorizationChecker(AuthorizationCheckerInterface $authChecker)
    {
        $this->authChecker              = $authChecker;
    }

    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    protected function createResource()
    {
        return new $this->entityClass();
    }

    /**
     * {@inheritdoc }
     */
    public function all($limit = 5, $offset = 0, $filters = array(), $params = array())
    {
        $entities = $this->repository->findMore($limit, $offset, $params, $filters);

        if (0 < count($entities))
            if ($entities && false === $this->authChecker->isGranted('LISTING', current($entities)))
                throw new AccessDeniedException('Accesso non autorizzato!');

        return $entities;
    }

    /**
     * {@inheritdoc }
     */
    public function delete($resource)
    {

        if (false === $this->authChecker->isGranted('DELETE', $resource))
            throw new AccessDeniedException('Accesso non autorizzato!');

        //$status = $this->om->remove($this->om->getReference('RufyRestApiBundle:Reservation', $reservationId));
        $status = $this->om->remove($resource);
        $this->om->flush();
    }

    /**
     * {@inheritdoc }
     */
    public function post(array $parameters)
    {
        $resource = $this->createResource();

        return $this->processForm($resource, $parameters, 'POST');
    }
}
