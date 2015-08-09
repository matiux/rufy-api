<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

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

    protected function getFormType()
    {
        return 'Rufy\RestApiBundle\Form\CustomerType';
    }
}
