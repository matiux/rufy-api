<?php namespace Rufy\RestApiBundle\Transformer\Fractal;

use League\Fractal;

use Rufy\RestApiBundle\Entity\ReservationOption;

class ReservationOptionTransformer extends Fractal\TransformerAbstract
{
    public function transform(ReservationOption $opts) {

        return [
            'id'    => $opts->getId(),
            'slug'  => $opts->getSlug(),
        ];
    }
}
