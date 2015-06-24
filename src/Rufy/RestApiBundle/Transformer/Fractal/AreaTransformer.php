<?php namespace Rufy\RestApiBundle\Transformer\Fractal;

use League\Fractal,
    League\Fractal\TransformerAbstract;

use Rufy\RestApiBundle\Entity\Area;

class AreaTransformer extends TransformerAbstract
{
    public function transform(Area $area)
    {
        return [

            'id'            => $area->getId(),
            'restaurantId'  => $area->getRestaurant()->getId(),
            'name'          => $area->getName(),
            'max_people'    => $area->getMaxPeople(),
        ];
    }
}
