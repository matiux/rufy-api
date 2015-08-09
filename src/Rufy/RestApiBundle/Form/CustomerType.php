<?php namespace Rufy\RestApiBundle\Form;

use Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomerType extends BaseType
{
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
            ->add('email')
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
