<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Rufy\RestApiBundle\Entity\Restaurant,
    Rufy\RestApiBundle\Exception\InvalidFormException,
    Rufy\RestApiBundle\Form\CustomerType,
    Rufy\RestApiBundle\Model\CustomerInterface,
    Rufy\RestApiBundle\Model\EntityInterface;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RestaurantHandler extends AbstractEntityHandler implements EntityHandlerInterface
{
    /**
     * {@inheritdoc }
     */
    public function get($id)
    {
        $restaurant = $this->repository->findCustom($id);

        if ($restaurant && false === $this->authChecker->isGranted('VIEW', $restaurant)) {
            throw new AccessDeniedException('Accesso non autorizzato!');
        }

        return $restaurant;
    }

    /**
     * {@inheritdoc }
     */
    public function all($limit = 5, $offset = 0, $filters = array(), $params = array())
    {
        $params['userId'] = $this->user->getId();

        return parent::all($limit, $offset, $filters, $params);
    }

    /**
     * Edit a Entity.
     *
     * @api
     *
     * @param $entity
     * @param array $parameters
     *
     * @return Entity
     */
    public function put($entity, array $parameters)
    {

    }

    /**
     * Partially update a Entity.
     *
     * @api
     *
     * @param $entity
     * @param array           $parameters
     *
     * @return Entity
     */
    public function patch($entity, array $parameters)
    {

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
         * Invece di new RestaurantType() passo 'restaurant_type' dato che RestaurantType
         * è registrato come servizio
         */
        $form = $this->formFactory->create('restaurant_type', $resource, array('method' => $method));

        $form->submit($parameters, 'PATCH' !== $method);

        if ($form->isValid()) {

            /**
             * @var $resource Reservation
             */
            $resource = $form->getData();

            if (false === $this->authChecker->isGranted('CREATE', $resource))
                throw new AccessDeniedException('Accesso non autorizzato!');

            $this->om->persist($resource);
            $this->om->flush();

            return $resource;
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }
}
