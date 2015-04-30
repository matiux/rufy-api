<?php namespace Rufy\RestApiBundle\Security\Authorization\Voter; 

use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * See http://symfony.com/blog/new-in-symfony-2-6-simpler-security-voters
 *
 * Class ReservationVoter
 * @package Rufy\RestApiBundle\Security\Authorization\Voter
 */
abstract class BaseVoter extends AbstractVoter
{
    const VIEW      = 'VIEW';
    const EDIT      = 'EDIT';
    const CREATE    = 'CREATE';
    const DELETE    = 'DELETE';
    const LISTING   = 'LISTING';

    /**
     * @var ObjectManager
     */
    protected $om;

    public function setObjectManager(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * {@inheritdoc}
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
}
