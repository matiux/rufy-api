<?php namespace Rufy\RestApiBundle\Security\Authorization\Voter;

use Rufy\RestApiBundle\Entity\Area;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface,
    Symfony\Component\Security\Core\User\UserInterface;

class AreaVoter extends BaseVoter
{
    /**
     * {@inheritdoc}
     */
    protected function getSupportedClasses()
    {
        return array('Rufy\RestApiBundle\Entity\Area');
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

        /**
         * @var $resource Area
         */

        switch($attribute) {
            case self::VIEW:
            case self::LISTING:
                if (
                    // Controllo che l'utente che vuole visualuzzare un'area o la lista delle aree, lavori per
                    $this->om->getRepository('RufyRestApiBundle:Restaurant')->hasUser($resource->getRestaurant(), $user)
                )
                    return VoterInterface::ACCESS_GRANTED;
                break;
        }

        return false;
    }
}
