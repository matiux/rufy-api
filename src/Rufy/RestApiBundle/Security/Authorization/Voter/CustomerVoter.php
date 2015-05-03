<?php namespace Rufy\RestApiBundle\Security\Authorization\Voter;

use Rufy\RestApiBundle\Entity\Customer;

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
        /**
         * @var $resource Customer
         */

        // si assicura che ci sia un utente (che abbia fatto login)
        if (!$user instanceof UserInterface)
            return VoterInterface::ACCESS_DENIED;

        switch($attribute) {
            case self::VIEW:
            case self::LISTING:
            case self::DELETE:
                if (
                    // Controllo che il clienter che si vuole visualizzare appartenga al ristorante dello user che lo richiede
                    $this->om->getRepository('RufyRestApiBundle:Restaurant')->hasCustomer($resource->getRestaurant(), $resource, $user)
                )
                    return VoterInterface::ACCESS_GRANTED;
                break;
            case self::CREATE:
                if (
                    // Controllo che l'utente che salva il customer, lavori nel ristorante che vuole associare al customer
                    $this->om->getRepository('RufyRestApiBundle:Restaurant')->hasUser($resource->getRestaurant(), $user)
                )
                    return VoterInterface::ACCESS_GRANTED;
                break;
        }

        return false;
    }
}
