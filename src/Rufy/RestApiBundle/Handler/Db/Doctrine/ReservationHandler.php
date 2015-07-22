<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Rufy\RestApiBundle\Entity\Reservation,
    Rufy\RestApiBundle\Exception\InvalidFormException,
    Rufy\RestApiBundle\Model\EntityInterface;

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
     * Processes the form.
     *
     * @param $resource
     * @param array $parameters
     * @param string $method
     * @return mixed
     * @throws InvalidFormException
     */
    protected function processForm($resource, array $parameters, $method = 'POST')
    {
        /**
         * Invece di new ReservationType() passo 'reservation_type' dato che ReservationType
         * è registrato come servizio
         */
        $form = $this->formFactory->create('reservation_type', $resource, array('method' => $method));

        $form->submit($parameters, 'PATCH' !== $method);

        if ($form->isValid()) {

            return $this->performSave($form->getData());
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    protected function performSave(EntityInterface $resource)
    {
        if (false === $this->authChecker->isGranted('CREATE', $resource))
            throw new AccessDeniedException('Accesso non autorizzato!');

        $resource->setUser($this->om->getReference('RufyRestApiBundle:User', $this->user->getId()));

        $this->om->persist($resource);

        if (!$this->waitForTransaction) {

            $this->om->flush();
        }

        return $resource;
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

    public function bindCustomerToReservation(Reservation $reservation, $customer)
    {
        $customer = !is_object($customer) ? $this->om->getReference('RufyRestApiBundle:Customer', $customer) : $customer;

        $reservation->setCustomer($customer);

        $this->om->persist($reservation);
        $this->om->flush();
    }
}
