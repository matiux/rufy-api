<?php namespace Rufy\RestApiBundle\Transformer\Fractal;

use League\Fractal;

class GenericTransformer extends Fractal\TransformerAbstract
{
    public function transform($generic)
    {
        $a = 1;

        return [

            'code'      => $generic->getCode(),
            'message'   => $generic->getMessage(),
            'errors'    => $generic->getErrors(),
        ];
    }
}
