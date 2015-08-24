<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Rufy\RestApiBundle\Model\EntityInterface;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ReservationHandler extends AbstractEntityHandler implements EntityHandlerInterface
{
    /**
     * {@inheritdoc }
     */
    public function get($id)
    {
        $reservation = $this->repository->findCustom($id);

        if ($reservation && false === $this->authChecker->isGranted('VIEW', $reservation)) {
            throw new AccessDeniedException('Accesso non autorizzato!');
        }

        return $reservation;
    }

    protected function performSave(EntityInterface $resource)
    {
        if (false === $this->authChecker->isGranted('CREATE', $resource))
            throw new AccessDeniedException('Accesso non autorizzato!');

        /**
         * TODO
         * Refactoring. GEstitlo a livello form con un un campèo hiddene un data transformer
         */
        $resource->setUser($this->om->getReference('RufyRestApiBundle:User', $this->user->getId()));

        $this->om->persist($resource);
        $this->om->flush();

        return $resource;
    }

    /**
     * {@inheritdoc }
     */
    public function patch(EntityInterface $reservation, Request $request)
    {
//        $this->om->persist($reservation);
//        $this->om->flush();

        return $this->processForm($reservation, $request, 'PATCH');
    }

    protected function getFormType()
    {
        return 'Rufy\RestApiBundle\Form\ReservationType';
    }
}
