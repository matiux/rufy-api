<?php namespace Rufy\RestApiBundle\Security\Authorization\Voter; 

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * See http://symfony.com/blog/new-in-symfony-2-6-simpler-security-voters
 *
 * Class ReservationVoter
 * @package Rufy\RestApiBundle\Security\Authorization\Voter
 */
class ReservationVoter extends AbstractVoter implements RufyVoterInterface
{
    use RufyVoterTrait;

    /**
     * @var ObjectManager
     */
    private $om;

    public function __construct(ObjectManager $om)
    {
        $this->om                      = $om;
    }

    /**
     * Return an array of supported classes. This will be called by supportsClass
     *
     * @return array an array of supported classes, i.e. array('Acme\DemoBundle\Model\Product')
     */
    protected function getSupportedClasses()
    {
        return array('Rufy\RestApiBundle\Entity\Reservation');
    }

    /**
     * Perform a single access check operation on a given attribute, object and (optionally) user
     * It is safe to assume that $attribute and $object's class pass supportsAttribute/supportsClass
     * $user can be one of the following:
     *   a UserInterface object (fully authenticated user)
     *   a string               (anonymously authenticated user)
     *
     * @param string $attribute
     * @param Reservation $resource
     * @param UserInterface|string $user
     *
     * @return bool
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
                if ($this->om->getRepository('RufyRestApiBundle:User')->hasReservation($resource, $user))
                    return VoterInterface::ACCESS_GRANTED;
                break;

            case self::CREATE:
                if (
                    // Controllo che l'area inserita appartenga a un ristorante dell'utente
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
