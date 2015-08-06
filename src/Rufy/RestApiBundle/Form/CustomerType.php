<?php namespace Rufy\RestApiBundle\Form;

use Doctrine\ORM\EntityManager;
use Rufy\RestApiBundle\Entity\User;
use Rufy\RestApiBundle\Repository\RestaurantRepository;
use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface,
    Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class CustomerType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var User
     */
    private $user;

    public function __construct(TokenStorage $tokenStorage, EntityManager $em)
    {
        $this->em                       = $em;
        $this->user                     = $tokenStorage->getToken()->getUser();
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $qb = $this->em->getRepository('RufyRestApiBundle:Restaurant')
                        ->createQueryBuilder('restaurant')
                        ->where('restaurant.id IN (:restaurants)')
                        ->setParameter('restaurants', $this->user->getRestaurants())
            ;

         $builder
            ->add('restaurant', 'entity', [
                'class'         => 'RufyRestApiBundle:Restaurant',
                'property'      => 'name',
                'placeholder'   => 'Scegliere un ristorante',
                'query_builder' => $qb

            ])
            ->add('name')
            ->add('phone')
            ->add('email', 'email')
            ->add('privacy')
            ->add('newsletter')
//            ->add('save', 'submit', [
//                'label' => 'Salva'
//            ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(

            'attr'              => ['novalidate' => 'novalidate'],
            'data_class'        => 'Rufy\RestApiBundle\Entity\Customer',
            'csrf_protection'   => false,

        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'customer_type';
    }
}
