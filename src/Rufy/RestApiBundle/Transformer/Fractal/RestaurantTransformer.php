<?php namespace Rufy\RestApiBundle\Transformer\Fractal;

use League\Fractal;

use Rufy\RestApiBundle\Entity\Restaurant;

class RestaurantTransformer extends Fractal\TransformerAbstract
{
    public function transform(Restaurant $restaurant) {

        return [

            'id'            => $restaurant->getName(),
            'restDate'      => $restaurant->getRestDate()
        ];
    }
}
