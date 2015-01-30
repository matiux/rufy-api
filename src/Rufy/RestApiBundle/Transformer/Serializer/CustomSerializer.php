<?php namespace Rufy\RestApiBundle\Transformer\Serializer;

use League\Fractal\Serializer\ArraySerializer;

class CustomSerializer extends ArraySerializer
{
    /**
     * Serialize a collection
     *
     * @param  string  $resourceKey
     * @param  array  $data
     * @return array
     **/
    public function collection($resourceKey, array $data)
    {
        return $data;
    }
}
