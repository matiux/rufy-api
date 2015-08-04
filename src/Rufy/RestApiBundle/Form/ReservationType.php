<?php namespace Rufy\RestApiBundle\Form;

use Doctrine\ORM\EntityRepository;
use Rufy\RestApiBundle\Entity\User;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface,
    Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer,
    Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ReservationType extends AbstractType
{
    /**
     * @var User
     */
    private $user;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->user                     = $tokenStorage->getToken()->getUser();
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('people')
            ->add('people_extra')
            ->add('time', 'time', ['input' => 'datetime', 'with_seconds' => false, 'widget' => 'single_text', 'model_timezone' => 'Europe/Rome'])
            ->add('date', 'date', ['widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'model_timezone' => 'Europe/Rome'])
            ->add('note')
            ->add('status', 'choice', [
                'choices' => [
                        0 => 'Waiting list',
                        1 => 'To confirm',
                        2 => 'Confirmed',
                ],
                'data' => 1,
            ])
            ->add('table_name')
//            ->add('customer', 'entity', [
//                                'class'     => 'RufyRestApiBundle:Customer',
//                                'property'  => 'id',
//            ])
            ->add('area', 'entity', [
                'class'         => 'RufyRestApiBundle:Area',
                'property'      => 'name',
                'placeholder'   => 'Scegliere un\'area',
            ])
            ->add('reservationOptions', 'entity', [
                                            'class'     => 'RufyRestApiBundle:ReservationOption',
                                            'property'  => 'slug',
                                            'expanded'  => true,
                                            'multiple'  => true,
//                                            'query_builder' => function(EntityRepository $er){
//
//                                                return $er->createQueryBuilder('ro')->leftJoin('ro.areas', 'a')->where('a.id');
//                                            }
                ]
            )
        ->add('customer', new CustomerType())
        ->add('save', 'submit', [
                'label' => 'Salva'
            ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(

            'attr'              => ['novalidate' => 'novalidate'],
            'data_class'        => 'Rufy\RestApiBundle\Entity\Reservation',
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
        return 'reservation_type';
    }
}
