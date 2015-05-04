<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AreaHandler extends AbstractEntityHandler implements EntityHandlerInterface
{
    /**
     * {@inheritdoc }
     */
    public function get($id)
    {
        $area = $this->repository->find($id);

        if ($area && false === $this->authChecker->isGranted('VIEW', $area)) {
            throw new AccessDeniedException('Accesso non autorizzato!');
        }

        return $area;
    }

    /**
     * {@inheritdoc }
     */
    public function post(array $parameters)
    {

    }

    /**
     * {@inheritdoc }
     */
    public function put($entity, array $parameters)
    {

    }

    /**
     * {@inheritdoc }
     */
    public function patch($entity, array $parameters)
    {

    }
}
