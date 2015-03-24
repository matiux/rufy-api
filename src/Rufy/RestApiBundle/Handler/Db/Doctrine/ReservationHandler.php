<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Rufy\RestApiBundle\Exception\InvalidFormException,
    Rufy\RestApiBundle\Form\ReservationType,
    Rufy\RestApiBundle\Model\ReservationInterface;

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
    public function all($limit = 5, $offset = 0, $filters = array(), $params = array())
    {
        $reservations = $this->repository->findReservations($limit, $offset, $params, $filters);

        if (0 < count($reservations))
            if ($reservations && false === $this->authChecker->isGranted('LISTING', current($reservations)))
                throw new AccessDeniedException('Accesso non autorizzato!');

        return $reservations;
    }

    /**
     * Post Reservation, creates a new Reservation.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return ReservationInterface
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
        $form = $this->formFactory->create(new ReservationType(), $resource, array('method' => $method));

        $form->submit($parameters, 'PATCH' !== $method);

        if ($form->isValid()) {

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
     * Edit a Reservation.
     *
     * @api
     *
     * @param ReservationInterface $reservation
     * @param array $parameters
     *
     * @return ReservationInterface
     */
    public function put($reservation, array $parameters)
    {
        return $this->processForm($reservation, $parameters, 'PUT');
    }

    /**
     * {@inheritdoc }
     */
    public function patch($reservation, array $parameters)
    {
        return $this->processForm($reservation, $parameters, 'PATCH');
    }

    /**
     * Delete an entity
     *
     * @api
     *
     * @param $entity
     * @return mixed
     */
    public function delete($entity)
    {

    }
}
