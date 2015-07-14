<?php namespace Rufy\RestApiBundle\Transformer\Fractal;

use League\Fractal,
    League\Fractal\TransformerAbstract;

use Rufy\RestApiBundle\Entity\Customer;

class CustomerTransformer extends TransformerAbstract
{
    public function transform(Customer $customer)
    {
        return [

            'name'          => $customer->getName(),
            'phone'         => $customer->getPhone(),
            'email'         => $customer->getEmail(),
            'privacy'       => $customer->getPrivacy() ? 1 : 0,
            'newsletter'    => $customer->getNewsletter() ? 1 : 0,
            'restaurant'    => $customer->getRestaurant()->getId(),
            'id'            => $customer->getId(),
        ];
    }
}
