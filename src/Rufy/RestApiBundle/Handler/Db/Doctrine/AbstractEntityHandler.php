<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;

use Rufy\RestApiBundle\Entity\Area,
    Rufy\RestApiBundle\Entity\Customer,
    Rufy\RestApiBundle\Entity\Reservation,
    Rufy\RestApiBundle\Entity\Restaurant,

    Rufy\RestApiBundle\Repository\AreaRepository,
    Rufy\RestApiBundle\Repository\CustomerRepository,
    Rufy\RestApiBundle\Repository\ReservationRepository,
    Rufy\RestApiBundle\Repository\RestaurantRepository,
    Rufy\RestApiBundle\Repository\UserRepository,

    Rufy\RestApiBundle\Model\EntityInterface,
    Rufy\RestApiBundle\Exception\InvalidFormException;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface,
    Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface,
    Symfony\Component\Form\FormFactoryInterface,
    Symfony\Component\Form\FormFactory,
    Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\HttpFoundation\Request;

abstract class AbstractEntityHandler
{
    /**
     * @var Reservation|Restaurant|Area|Customer
     */
    protected $entityClass;

    /**
     * @var ReservationRepository|RestaurantRepository|AreaRepository|CustomerRepository
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

    /**
     * @var TokenStorageInterface
     */
    protected $token_storage;

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
        $this->token_storage            = $tokenStorage;

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

        // TODO
        //        if (0 < count($entities))
        //            if ($entities && false === $this->authChecker->isGranted('LISTING', current($entities)))
        //                throw new AccessDeniedException('Accesso non autorizzato!');

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
    public function post(Request $request)
    {
        $resource = $this->createResource();

        return $this->processForm($resource, $request, 'POST');
    }

    /**
     * Processes the form.
     *
     * @param $resource
     * @param Request $request
     * @param string $method
     * @return EntityInterface
     */
    protected function processForm($resource, Request $request, $method = 'POST')
    {
        /**
         * Ottengo qualcosa come reservation_type
         * $type = explode('\\', strtolower(str_replace('Handler', '_type', get_called_class())))[5];
         *
         * Invece di new ReservationType() passo 'customer_type' dato che CustomerType
         * è registrato come servizio
         * ReservationType non è più registrato come servizio in quanto ho dovuto far ritornare al metodo
         * ReservationType::getName() una stringa vuota per avere gli attributi name dei campi coerenti con
         * il client
         */
        //$form = $this->formFactory->create($type, $resource, ['method' => $method]);
        $form = $this->formFactory->create(new ReservationType($this->token_storage, $this->om), $resource, ['method' => $method]);

        /**
         * http://symfony.com/it/doc/2.7/book/forms.html#gestione-dell-invio-del-form
         * $form->submit($parameters, 'PATCH' !== $method);
         */
        $form->handleRequest($request);

        if ($form->isValid()) {

            return $this->performSave($form->getData());
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    protected function performSave(EntityInterface $resource)
    {
        if (false === $this->authChecker->isGranted('CREATE', $resource))
            throw new AccessDeniedException('Accesso non autorizzato!');

        $this->om->persist($resource);
        $this->om->flush();

        return $resource;
    }
}
