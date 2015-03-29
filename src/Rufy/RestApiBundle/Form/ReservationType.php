<?php namespace Rufy\RestApiBundle\Form;

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
        $timeTransformer = new DateTimeToStringTransformer('Europe/Rome', 'Europe/Rome', 'H:i:s');
        $dateTransformer = new DateTimeToStringTransformer('Europe/Rome', 'Europe/Rome', 'Y-m-d');

        $builder
            ->add('people')
            //->add('time', 'time', ['input' => 'string', 'with_seconds' => true, 'widget' => 'single_text'])
            ->add($builder->create('time', 'text')->addModelTransformer($timeTransformer))
            //->add('date', 'date', ['widget' => 'single_text', 'format' => 'yyyy-MM-dd'])
            ->add($builder->create('date', 'text')->addModelTransformer($dateTransformer))
            ->add('note')
            ->add('confirmed')
            ->add('waiting')
            ->add('table_name')
//            ->add('drawing_width')
//            ->add('drawing_height')
//            ->add('drawing_pos_x')
//            ->add('drawing_pos_y')
//            ->add('user', 'entity', array('class' => 'RufyRestApiBundle:User', 'property' => 'id'))
            ->add('customer', 'entity', array('class' => 'RufyRestApiBundle:Customer', 'property' => 'id'))
            ->add('area', 'entity', array('class' => 'RufyRestApiBundle:Area', 'property' => 'id'))
            ->add('reservationOptions', 'entity', array('class' => 'RufyRestApiBundle:ReservationOption', 'property' => 'slug', 'expanded' => true ,
                'multiple' => true , ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(

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
