<?php namespace Rufy\RestApiBundle\Transformer\Fractal\Serializer;

use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Serializer\DataArraySerializer;

class CustomSerializer extends DataArraySerializer
{
    /**
     * Serialize a collection
     *
     * @param  array  $data
     * @return array
     **/
    public function collection($resourceKey, array $data)
    {
        return array('data' => $data, 'meta' => []);
    }

    /**
     * Serialize an item
     *
     * @param  array  $data
     * @return array
     **/
    public function item($resourceKey, array $data)
    {
        return array('data' => $data, 'meta' => []);
    }
}
