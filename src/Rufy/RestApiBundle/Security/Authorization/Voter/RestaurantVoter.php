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

        $a= 1;

        switch($attribute) {
            case self::VIEW:
            case self::LISTING:
                if ($this->om->getRepository('RufyRestApiBundle:Restaurant')->hasUSer($resource, $user))
                    return VoterInterface::ACCESS_GRANTED;
                break;
        }
    }
}
