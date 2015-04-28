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

    }

    /**
     * {@inheritdoc }
     */
    public function post(array $parameters)
    {
        $customer = $this->createResource();

        return $this->processForm($reservation, $parameters, 'POST');
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
     * Partially update a Entity.
     *
     * @param $entity
     * @param array $parameters
     *
     * @return Entity
     */
    public function patch($entity, array $parameters)
    {

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
