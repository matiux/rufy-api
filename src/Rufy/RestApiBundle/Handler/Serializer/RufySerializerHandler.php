<?php namespace Rufy\RestApiBundle\Handler\Serializer;

use League\Fractal\Manager,
    League\Fractal\Resource\Item,
    League\Fractal\Resource\Collection;

use Rufy\RestApiBundle\Transformer\Fractal\Serializer\CustomSerializer;

class RufySerializerHandler
{
    const TRANSFORMER_PATH = 'Rufy\RestApiBundle\Transformer\Fractal\\';

    private $_resourceClassName;
    private $_transformer;

    private $_fractalManager;
    private $_customFractalSerializer;

    public function __construct(Manager $fractalManager, CustomSerializer $customFractalSerializer) {

        $this->_fractalManager                  = $fractalManager;
        $this->_customFractalSerializer         = $customFractalSerializer;
    }

    public function serialize($resource, $type)
    {
        $type = is_array($resource) ? 'COLLECTION' : 'ITEM';

        switch ($type) {
            case 'ITEM':
                return $this->serializeItem($resource);
                break;
            case 'COLLECTION':
                return $this->serializeCollection($resource);
                break;
        }
    }

    private function serializeItem($resource)
    {
        $this->initManager($resource);

        $resource = new Item($resource, $this->_transformer);

        return $this->_fractalManager->createData($resource)->toJson();
    }

    private function serializeCollection($resource)
    {
        if (0 < count($resource)) {
            $this->initManager(current($resource));
        }

        $resource = new Collection($resource, $this->_transformer);

        return $this->_fractalManager->createData($resource)->toJson();
    }

    private function initManager($resource)
    {

        $entity = get_class($resource);

        $dirs                               = explode('\\', $entity);
        $this->_resourceClassName           = $dirs[count($dirs) - 1];

        $this->_fractalManager->setSerializer($this->_customFractalSerializer);

        $this->_transformer = $this->getTransformer();
    }

    private function getTransformer() {

        $class = static::TRANSFORMER_PATH.$this->_resourceClassName.'Transformer';

        return new $class();

    }
}
