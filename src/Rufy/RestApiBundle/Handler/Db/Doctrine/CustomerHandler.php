<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Rufy\RestApiBundle\Entity\Customer;
use Rufy\RestApiBundle\Exception\InvalidFormException,
    Rufy\RestApiBundle\Form\CustomerType,
    Rufy\RestApiBundle\Model\CustomerInterface;

use Rufy\RestApiBundle\Model\EntityInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CustomerHandler extends AbstractEntityHandler implements EntityHandlerInterface
{
    /**
     * Get a Entity given the identifier
     *
     * @param int $id
     *
     * @return Entity
     */
    public function get($id)
    {
        $customer = $this->repository->findCustom($id);

        if ($customer && false === $this->authChecker->isGranted('VIEW', $customer)) {
            throw new AccessDeniedException('Accesso non autorizzato!');
        }

        return $customer;
    }

    /**
     * {@inheritdoc }
     */
    public function post(array $parameters)
    {
        $customer = $this->createResource();

        return $this->processForm($customer, $parameters, 'POST');
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
    private function processForm($resource, array $parameters, $method = 'POST')
    {
        /**
         * Invece di new ReservationType() passo 'customer_type' dato che CustomerType
         * è registrato come servizio
         */
        $form = $this->formFactory->create('customer_type', $resource, array('method' => $method));

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

    /**
     * Edit a Entity.
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
     * {@inheritdoc }
     */
    public function patch($customer, array $parameters)
    {
        $this->om->persist($customer);
        $this->om->flush();

        return $this->processForm($customer, $parameters, 'PATCH');
    }

    /**
     * Delete an entity
     *
     * @param $entity
     * @return mixed
     */
    public function delete($entity)
    {

    }
}
