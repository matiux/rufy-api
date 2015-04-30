<?php namespace Rufy\RestApiBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface,
    Symfony\Component\Security\Core\User\UserInterface;

class CustomerVoter extends BaseVoter
{
    /**
     * {@inheritdoc}
     */
    protected function getSupportedClasses()
    {
        return array('Rufy\RestApiBundle\Entity\Customer');
    }

    /**
     * {@inheritdoc}
     */
    protected function isGranted($attribute, $resource, $user = null)
    {
        // si assicura che ci sia un utente (che abbia fatto login)
        if (!$user instanceof UserInterface)
            return VoterInterface::ACCESS_DENIED;

        switch($attribute) {
            case self::CREATE:
                if (
                    // Controllo che il ristorante appartenga all'utente che salva il Customer
                    //$this->om->getRepository('RufyRestApiBundle:User')->hasArea($resource, $user)
                    true
                )
                    return VoterInterface::ACCESS_GRANTED;
                break;
        }

        return false;
    }
}
