<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Rufy\RestApiBundle\Exception\InvalidFormException,
    Rufy\RestApiBundle\Form\ReservationType,
    Rufy\RestApiBundle\Model\ReservationInterface;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ReservationHandler extends AbstractEntityHandler implements HandlerInterface
{
    /**
     * Get a Reservation given the identifier and checking that the reservation belongs to the user who invokes
     *
     * @api
     *
     * @param int $id - Reservation ID
     *
     * @return ReservationInterface
     * @return null
     *
     * @throws AccessDeniedException
     */
    public function get($id)
    {
        $reservation = $this->repository->findCustom($id);

        if (false === $this->authChecker->isGranted('VIEW', $reservation)) {
            throw new AccessDeniedException('Accesso non autorizzato!');
        }

        return $reservation;
    }

    /**
     * Get a list of Reservations.
     *
     * @param int $limit            the limit of the result
     * @param int $offset           starting from the offset
     * @param array $params         filter params
     *
     * @return array
     *
     * @throws AccessDeniedException if the resource is not accessible
     */
    public function all($limit = 5, $offset = 0, $params = array())
    {
        $reservations = $this->repository->findReservations($limit, $offset, $params);

        if (0 < count($reservations))
            if (false === $this->authChecker->isGranted('LISTING', current($reservations)))
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
            $this->om->persist($resource);
            $this->om->flush($resource);

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
     * Partially update a Reservation.
     *
     * @api
     *
     * @param ReservationInterface $reservation
     * @param array $parameters
     *
     * @return ReservationInterface
     */
    public function patch($reservation, array $parameters)
    {
        return $this->processForm($reservation, $parameters, 'PATCH');
    }
}
