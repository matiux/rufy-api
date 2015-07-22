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
    Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
     * Se true, non fa il flush dell'entità attendendo il prossimo salvataggio.
     * Si verifica ad esempio nel caso del salvataggio del Customer che viene salvato
     * prima della Reservation ma deve essere commitato solo se la Reservation è valida
     * @var bool
     */
    protected $waitForTransaction = false;

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
    public function post(array $parameters, $wft = false)
    {
        $this->waitForTransaction = $wft;

        $resource = $this->createResource();

        return $this->processForm($resource, $parameters, 'POST');
    }

    /**
     * Processes the form.
     *
     * @param $resource
     * @param array $parameters
     * @param string $method
     * @return mixed
     * @throws InvalidFormException
     */
    protected function processForm($resource, array $parameters, $method = 'POST')
    {
        /**
         * Ottengo qualcosa come reservation_type
         */
        $type = explode('\\', strtolower(str_replace('Handler', '_type', get_called_class())))[5];

        /**
         * Invece di new ReservationType() passo 'customer_type' dato che CustomerType
         * è registrato come servizio
         */
        $form = $this->formFactory->create($type, $resource, array('method' => $method));

        $form->submit($parameters, 'PATCH' !== $method);

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

        if (!$this->waitForTransaction) {

            $this->om->flush();
        }

        return $resource;
    }
}
