<?php namespace Rufy\RestApiBundle\Transformer\Fractal;

use League\Fractal;

class FormErrorTransformer extends Fractal\TransformerAbstract
{
    public function transform($formError)
    {
        return [

            'name'          => $formError['name'],
            'generic'       => $formError['generic'],
            'wrong_value'   => $formError['wrong_value'],
            'cause'         => $formError['cause'],

        ];
    }
}
