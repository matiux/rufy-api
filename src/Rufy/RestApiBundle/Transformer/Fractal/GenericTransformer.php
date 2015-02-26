<?php namespace Rufy\RestApiBundle\Transformer\Fractal;

use FOS\RestBundle\Util\ExceptionWrapper;
use League\Fractal;

class GenericTransformer extends Fractal\TransformerAbstract
{
    public function transform(ExceptionWrapper $notFound)
    {
        return [
            'code'      => $notFound->getCode(),
            'message'   => $notFound->getMessage(),
            'errors'    => $notFound->getErrors(),
        ];
    }
}
