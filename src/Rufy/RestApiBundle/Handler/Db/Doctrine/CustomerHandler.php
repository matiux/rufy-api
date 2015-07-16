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
        return $this->processForm($customer, $parameters, 'PATCH');
    }

}
