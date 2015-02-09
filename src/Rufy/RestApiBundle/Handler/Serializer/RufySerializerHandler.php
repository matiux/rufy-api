<?php namespace Rufy\RestApiBundle\Handler\Serializer;

use League\Fractal\Manager,
    League\Fractal\Resource\Item,
    League\Fractal\Resource\Collection;

use Rufy\RestApiBundle\Transformer\Fractal\Serializer\CustomSerializer;

class RufySerializerHandler
{
    const TRANSFORMER_PATH      = 'Rufy\RestApiBundle\Transformer\Fractal\\';
    const TRANSFORMER_SUFFIX    = 'Transformer';

    private $resourceClassName;
    private $transformer;

    private $fractalManager;
    private $customFractalSerializer;

    public function __construct(Manager $fractalManager, CustomSerializer $customFractalSerializer) {

        $this->fractalManager                  = $fractalManager;
        $this->customFractalSerializer         = $customFractalSerializer;
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

        $resource = new Item($resource, $this->transformer);

        return $this->fractalManager->createData($resource)->toJson();
    }

    private function serializeCollection($resource)
    {
        if (0 < count($resource)) {
            $this->initManager(current($resource));
        }

        $resource = new Collection($resource, $this->transformer);

        return $this->fractalManager->createData($resource)->toJson();
    }

    private function initManager($resource)
    {
        $entity = get_class($resource);

        $dirs                               = explode('\\', $entity);
        $this->resourceClassName            = $dirs[count($dirs) - 1];

        $this->fractalManager->setSerializer($this->customFractalSerializer);

        $this->transformer = $this->getTransformer();
    }

    private function getTransformer() {

        $class = static::TRANSFORMER_PATH.$this->resourceClassName.static::TRANSFORMER_SUFFIX;

        return new $class();

    }
}
