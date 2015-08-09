<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

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
}
