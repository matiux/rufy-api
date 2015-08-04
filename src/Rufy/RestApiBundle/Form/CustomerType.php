<?php namespace Rufy\RestApiBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface,
    Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer,
    Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class CustomerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('restaurant', 'entity', [
                'class'         => 'RufyRestApiBundle:Restaurant',
                'property'      => 'name',
                'placeholder'   => 'Scegliere un ristorante',
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
