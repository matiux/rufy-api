<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Rufy\RestApiBundle\Entity\Reservation,
    Rufy\RestApiBundle\Exception\InvalidFormException;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

    /**
     * {@inheritdoc }
     */
    public function post(array $parameters)
    {
        $reservation = $this->createResource();

        return $this->processForm($reservation, $parameters, 'POST');
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
         * Invece di new ReservationType() passo 'reservation_type' dato che ReservationType
         * è registrato come servizio
         */
        $form = $this->formFactory->create('reservation_type', $resource, array('method' => $method));

        $form->submit($parameters, 'PATCH' !== $method);

        if ($form->isValid()) {

            /**
             * @var $resource Reservation
             */
            $resource = $form->getData();

            if (false === $this->authChecker->isGranted('CREATE', $resource))
                throw new AccessDeniedException('Accesso non autorizzato!');

            $resource->setUser($this->om->getReference('RufyRestApiBundle:User', $this->user->getId()));
            $this->om->persist($resource);
            $this->om->flush();

            return $resource;
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    /**
     * {@inheritdoc }
     */
    public function put($reservation, array $parameters)
    {
        //return $this->processForm($reservation, $parameters, 'PUT');
    }

    /**
     * {@inheritdoc }
     */
    public function patch($reservation, array $parameters)
    {
        $reservation->getReservationOptions()->clear();
        $this->om->persist($reservation);
        $this->om->flush();

        return $this->processForm($reservation, $parameters, 'PATCH');
    }
}
