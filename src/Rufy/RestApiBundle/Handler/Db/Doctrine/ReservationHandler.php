<?php namespace Rufy\RestApiBundle\Handler\Db\Doctrine;

use Rufy\RestApiBundle\Entity\Customer;
use Rufy\RestApiBundle\Entity\Reservation,
    Rufy\RestApiBundle\Exception\InvalidFormException,
    Rufy\RestApiBundle\Model\EntityInterface;

use Rufy\RestApiBundle\Form\ReservationType;
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
     * @param Request $request
     * @param string $method
     * @return EntityInterface
     */
    protected function processForm($resource, Request $request, $method = 'POST')
    {
        $form = $this->formFactory->create(new ReservationType($this->token_storage, $this->om), $resource, ['method' => $method]);

        /**
         * http://symfony.com/it/doc/2.7/book/forms.html#gestione-dell-invio-del-form
         * $form->submit($parameters, 'PATCH' !== $method);
         */
        $form->handleRequest($request);

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
        $this->om->flush();

        return $resource;
    }

    /**
     * {@inheritdoc }
     */
    public function patch(EntityInterface $reservation, Request $request)
    {
//        $reservation->getReservationOptions()->clear();
//        $this->om->persist($reservation);
//        $this->om->flush();

        return $this->processForm($reservation, $request, 'PATCH');
    }

    public function bindCustomerToReservation(Reservation $reservation, $customer)
    {
        $customer = !is_object($customer) ? $this->om->getReference('RufyRestApiBundle:Customer', $customer) : $customer;

        $reservation->setCustomer($customer);

        $this->om->persist($reservation);
        $this->om->flush();
    }
}
