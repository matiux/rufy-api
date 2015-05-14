<?php namespace Rufy\RestApiBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface,
    Symfony\Component\Security\Core\User\UserInterface;

class RestaurantVoter extends BaseVoter
{
    /**
     * {@inheritdoc}
     */
    protected function getSupportedClasses()
    {
        return array('Rufy\RestApiBundle\Entity\Restaurant');
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
            case self::DELETE:
                // Qui non ho bisogno di controlli particolari dato che  nel Controller controllo già che l'utente che cancella sia un ADMIN
                return VoterInterface::ACCESS_GRANTED;
            case self::VIEW:
            case self::LISTING:
                if (
                    $this->om->getRepository('RufyRestApiBundle:Restaurant')->hasUser($resource, $user)
                )
                    return VoterInterface::ACCESS_GRANTED;
                break;
            case self::CREATE:
                // Qui non ho bisogno di controlli particolari dato che  nel Controller controllo già che l'utente che crea sia un ADMIN
                return VoterInterface::ACCESS_GRANTED;
                break;
        }
    }
}
