<?php namespace Rufy\RestApiBundle\Security\Authorization\Voter;

use Rufy\RestApiBundle\Entity\Reservation;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface,
    Symfony\Component\Security\Core\User\UserInterface;

class ReservationVoter extends BaseVoter
{
    /**
     * {@inheritdoc}
     */
    protected function getSupportedClasses()
    {
        return array('Rufy\RestApiBundle\Entity\Reservation');
    }

    /**
     * {@inheritdoc}
     */
    protected function isGranted($attribute, $resource, $user = null)
    {
        /**
         * si assicura che ci sia un utente (che abbia fatto login)
         * Lo faccio nelle azioni del controller
         */
        //if (!$user instanceof UserInterface) {
        //    return VoterInterface::ACCESS_DENIED;
        //}

        /**
         * @var $reservation Reservation
         */

        switch($attribute) {
            case self::VIEW:
            case self::LISTING:
            case self::DELETE:
                if ($this->om->getRepository('RufyRestApiBundle:User')->hasReservation($resource, $user))
                    return VoterInterface::ACCESS_GRANTED;
                break;

            case self::CREATE:
                if (

                    // Controllo che l'area appartenga al ristorante
                    $this->om->getRepository('RufyRestApiBundle:Restaurant')->hasArea($resource->getCustomer()->getRestaurant(), $resource->getArea())

                    // Controllo che l'area inserita appartenga a un ristorante per il quale lavora l'utente
                    && $this->om->getRepository('RufyRestApiBundle:User')->hasArea($resource->getArea(), $user)

                    // Controllo che il cliente per il quale si vuole fare la prenotazione appartenga al ristorante dell'utente
                    && $this->om->getRepository('RufyRestApiBundle:Restaurant')->hasCustomer($resource->getCustomer(), $user)

                    // Controllo che le opzioni dell'area appartengano all'area del ristorante dell'utente
                    //&& $this->om->getRepository('RufyRestApiBundle:Area')->hasOptions($resource)
                )
                    return VoterInterface::ACCESS_GRANTED;
                break;
        }

        return false;
    }
}
