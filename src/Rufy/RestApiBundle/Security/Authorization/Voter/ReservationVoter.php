<?php namespace Rufy\RestApiBundle\Security\Authorization\Voter; 

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ReservationVoter implements VoterInterface
{
    const VIEW      = 'view';
    const EDIT      = 'edit';
    const CREATE    = 'create';
    const DELETE    = 'delete';
    const LISTING   = 'listing';

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $_om;

    public function __construct(ObjectManager $om)
    {
        $this->_om                      = $om;
    }

    /**
     * Checks if the voter supports the given attribute.
     *
     * @param string $attribute An attribute
     *
     * @return bool true if this Voter supports the attribute, false otherwise
     */
    public function supportsAttribute($attribute)
    {
        return in_array($attribute, [
                                self::VIEW,
                                self::EDIT,
                                self::CREATE,
                                self::DELETE,
                                self::LISTING,
                            ]);
    }

    /**
     * Checks if the voter supports the given class.
     *
     * @param string $class A class name
     *
     * @return bool true if this Voter can process the class
     */
    public function supportsClass($class)
    {
        $supportedClass = 'Rufy\RestApiBundle\Entity\Reservation';

        return $supportedClass === $class || is_subclass_of($class, $supportedClass);
    }

    /**
     * Returns the vote for the given parameters.
     *
     * This method must return one of the following constants:
     * ACCESS_GRANTED, ACCESS_DENIED, or ACCESS_ABSTAIN.
     *
     * @param TokenInterface $token A TokenInterface instance
     * @param \Rufy\RestApiBundle\Entity\Reservation $reservation The object to secure
     * @param array $attributes An array of attributes associated with the method being invoked
     *
     * @return int either ACCESS_GRANTED, ACCESS_ABSTAIN, or ACCESS_DENIED
     *
     * @throws InvalidArgumentException
     */
    public function vote(TokenInterface $token, $reservation, array $attributes)
    {
        // verifica se la classe di questo oggetto sia supportata da questo votante
        if (!$this->supportsClass(get_class($reservation))) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        // verifica se il votante è usato correttamente, consente un singolo attributo
        // questo non è un requisito, ma solo un modo semplice per
        // progettare un votante
        if(1 !== count($attributes)) {
            throw new InvalidArgumentException(
                'È consentito un solo attributo per VIEW, EDIT, CREATE o DELETE'
            );
        }

        // imposta l'attributo da verificare
        $attribute = $attributes[0];

        // verifica se l'attributo dato sia coperto da questo votante
        if (!$this->supportsAttribute($attribute)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        // ottiene l'utente corrente
        $user = $token->getUser();

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
                if ($this->_om->getRepository('RufyRestApiBundle:User')->hasReservation($reservation, $user))
                    return VoterInterface::ACCESS_GRANTED;
                break;
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
