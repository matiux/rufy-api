<?php namespace Rufy\RestApiBundle\Security\Authorization\Voter; 

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Rufy\RestApiBundle\Entity\Reservation;

/**
 * See http://symfony.com/blog/new-in-symfony-2-6-simpler-security-voters
 *
 * Class ReservationVoter
 * @package Rufy\RestApiBundle\Security\Authorization\Voter
 */
class ReservationVoter extends AbstractVoter implements RufyVoretInterface
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $_om;

    public function __construct(ObjectManager $om)
    {
        $this->_om                      = $om;
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
     * Return an array of supported attributes. This will be called by supportsAttribute
     *
     * @return array an array of supported attributes, i.e. array('CREATE', 'READ')
     */
    protected function getSupportedAttributes()
    {
        return [
            self::CREATE,
            self::DELETE,
            self::EDIT,
            self::LISTING,
            self::VIEW,
        ];
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

        /**
         * TODO
         * Capire se il metodo hasReservation può accettare solo reservation
         */
        switch($attribute) {
            case self::VIEW:
                if ($this->_om->getRepository('RufyRestApiBundle:User')->hasReservation($resource, $user))
                    return VoterInterface::ACCESS_GRANTED;
                break;
            case self::LISTING:
                if ($this->_om->getRepository('RufyRestApiBundle:User')->hasReservation($resource, $user))
                    return VoterInterface::ACCESS_GRANTED;
                break;
        }

        return false;
    }
}
