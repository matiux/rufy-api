<?php namespace Rufy\RestApiBundle\Form;

use Doctrine\ORM\EntityManager;
use Rufy\RestApiBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

abstract class BaseType extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    public function __construct(TokenStorage $tokenStorage, EntityManager $em)
    {
        $this->em                       = $em;
        $this->tokenStorage             = $tokenStorage;
        $this->user                     = $tokenStorage->getToken()->getUser();
    }
}
