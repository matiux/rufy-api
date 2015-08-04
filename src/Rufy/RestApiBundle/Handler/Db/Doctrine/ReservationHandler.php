<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Rufy\RestApiBundle\Entity\Customer;
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

    protected function prepareResource(Reservation $resource, array $parameters)
    {
        $parameters['time'] = new \DateTime($parameters['time']);
        $parameters['date'] = new \DateTime($parameters['date']);

        $customer = $parameters['customer'];
        unset($parameters['customer']);

        $customerO = new Customer();

        foreach ($customer as $key => $value) {

            if ($key == 'restaurant') {

                $customerO->setRestaurant($this->om->getReference('Rufy\RestApiBundle\Entity\Restaurant', $value));

            } else {

                $method = 'set'.join('', array_map('ucfirst', explode('_', $key)));

                $customerO->$method($value);
            }
        }

        foreach ($parameters as $key => $value) {

            if ($key == 'area') {

                $resource->setArea($this->om->getReference('Rufy\RestApiBundle\Entity\Area', $value));

            } else {

                $method = 'set'.join('', array_map('ucfirst', explode('_', $key)));

                $resource->$method($value);
            }
        }

        $resource->setCustomer($customerO);

        return $resource;
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
        $this->prepareResource($resource, $parameters);



        /**
         * Invece di new ReservationType() passo 'reservation_type' dato che ReservationType
         * è registrato come servizio
         */
        $form = $this->formFactory->create('reservation_type', new Reservation(), array('method' => $method, 'em' => $this->om));

        $form->submit($parameters, 'PATCH' !== $method);


        if ($form->isValid()) {

            return $this->performSave($form->getData());
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    protected function performSave(EntityInterface $resource)
    {
//        if (false === $this->authChecker->isGranted('CREATE', $resource))
//            throw new AccessDeniedException('Accesso non autorizzato!');

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
