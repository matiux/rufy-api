<?php namespace Rufy\RestApiBundle\Form; 

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('people')
            ->add('note')
            ->add('confirmed')
            ->add('waiting')
            ->add('table_name')
            ->add('drawing_width')
            ->add('drawing_height')
            ->add('drawing_pos_x')
            ->add('drawing_pos_y')
            ->add('user')
            ->add('customer')
            ->add('area_id')
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
        return '';
    }
}
