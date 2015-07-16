<?php namespace Rufy\RestApiBundle\Handler\Serializer;

use FOS\RestBundle\Util\ExceptionWrapper;
use League\Fractal\Manager
    ;

use Rufy\RestApiBundle\Transformer\Fractal\Serializer\CustomSerializer
    ;



class RufyExceptionSerializerHandler
{
    private $fractalManager;
    private $customFractalSerializer;

    public function __construct(Manager $fractalManager, CustomSerializer $customFractalSerializer)
    {
        $this->fractalManager                  = $fractalManager;
        $this->customFractalSerializer         = $customFractalSerializer;
    }

    public function wrap($data)
    {
        return new ExceptionWrapper($data);
    }

}
