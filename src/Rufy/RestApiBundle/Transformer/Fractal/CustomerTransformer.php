<?php namespace Rufy\RestApiBundle\Transformer\Fractal;

use League\Fractal,
    League\Fractal\TransformerAbstract;

use Rufy\RestApiBundle\Entity\Customer;

class CustomerTransformer extends TransformerAbstract
{
    public function transform(Customer $customer)
    {
        return [

            'id'            => $customer->getId(),
            'name'          => $customer->getName(),
            'restaurant'    => $customer->getRestaurant()->getName(),
            'phone'         => $customer->getPhone(),
            'email'         => $customer->getEmail(),
            'privacy'       => $customer->getPrivacy() ? 1 : 0,
            'newsletter'    => $customer->getNewsletter() ? 1 : 0,
        ];
    }
}
