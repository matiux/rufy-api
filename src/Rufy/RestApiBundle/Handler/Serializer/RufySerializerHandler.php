<?php namespace Rufy\RestApiBundle\Handler\Serializer;

use League\Fractal\Manager,
    League\Fractal\Resource\Item;

use Rufy\RestApiBundle\Transformer\Fractal\Serializer\CustomSerializer;

class RufySerializerHandler
{
    const TRANSFORMER_PATH = 'Rufy\RestApiBundle\Transformer\Fractal\\';

    private $_resourceType;
    private $_resourceClassName;
    private $_transformer;

    private $_fractalManager;
    private $_customFractalSerializer;

    public function __construct(Manager $fractalManager, CustomSerializer $customFractalSerializer) {

        $this->_fractalManager                  = $fractalManager;
        $this->_customFractalSerializer         = $customFractalSerializer;
    }

    public function serialize($entity, $type)
    {
        $this->setResourceType(get_class($entity));

        $this->_fractalManager->setSerializer($this->_customFractalSerializer);

        $this->_transformer          = $this->getTransformer();

        $resource                   = new Item($entity, $this->_transformer);

        return $this->_fractalManager->createData($resource)->toJson();
    }

    private function setResourceType($entity) {

        $this->_resourceType                = $entity;
        $dirs                               = explode('\\', $entity);
        $this->_resourceClassName           = $dirs[count($dirs) - 1];
    }

    private function getTransformer() {

        $class = static::TRANSFORMER_PATH.$this->_resourceClassName.'Transformer';

        return new $class();

    }
}
