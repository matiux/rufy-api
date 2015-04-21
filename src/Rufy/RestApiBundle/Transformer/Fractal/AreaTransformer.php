<?php namespace Rufy\RestApiBundle\Transformer\Fractal;

use League\Fractal;

use Rufy\RestApiBundle\Entity\Area;

class AreaTransformer extends Fractal\TransformerAbstract
{
    public function transform(Area $area)
    {
        return [

            'id'            => $area->getId(),
            'restaurant_id' => $area->getRestaurant()->getId(),
            'name'          => $area->getName(),
            'full'          => $area->getFull(),
            'max_people'    => $area->getMaxPeople(),
        ];
    }
}
