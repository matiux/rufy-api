<?php namespace Rufy\RestApiBundle\Transformer\Fractal\Serializer;

use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Serializer\DataArraySerializer;

class CustomSerializer extends DataArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        return $data;
    }

    public function item($resourceKey, array $data)
    {
        return $data;
    }
}
