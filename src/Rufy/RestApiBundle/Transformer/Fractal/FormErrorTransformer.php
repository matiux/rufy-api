<?php namespace Rufy\RestApiBundle\Transformer\Fractal;

use League\Fractal;
use Rufy\RestApiBundle\Exception\InvalidFormException;

class FormErrorTransformer extends Fractal\TransformerAbstract
{
    public function transform(InvalidFormException $formError)
    {
        $formError = $formError->getErrors()['form_errors'];

        return [

            'name'          => $formError['name'],
            'generic'       => $formError['generic'],
            'wrong_value'   => $formError['wrong_value'],
            'cause'         => $formError['cause'],

        ];
    }
}
