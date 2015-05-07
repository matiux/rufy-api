<?php namespace Rufy\RestApiBundle\Security\Authorization\Voter;

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
        // si assicura che ci sia un utente (che abbia fatto login)
        if (!$user instanceof UserInterface) {
            return VoterInterface::ACCESS_DENIED;
        }

        switch($attribute) {
            case self::VIEW:
            case self::LISTING:
            case self::DELETE:
                if ($this->om->getRepository('RufyRestApiBundle:User')->hasReservation($resource, $user))
                    return VoterInterface::ACCESS_GRANTED;
                break;

            case self::CREATE:
                if (
                    // Controllo che l'area inserita appartenga a un ristorante per il quale lavora l'utente
                    $this->om->getRepository('RufyRestApiBundle:User')->hasArea($resource, $user) &&
                    // Controllo che il cliente per il quale si vuole fare la prenotazione appartenga al ristorante dell'utente
                    $this->om->getRepository('RufyRestApiBundle:Restaurant')->hasCustomer($resource->getArea()->getRestaurant(), $resource->getCustomer(), $user) &&
                    // Controllo che le opzioni dell'area appartengano all'area del ristorante dell'utente
                    $this->om->getRepository('RufyRestApiBundle:Area')->hasOptions($resource)
                )
                    return VoterInterface::ACCESS_GRANTED;
                break;
        }

        return false;
    }
}
