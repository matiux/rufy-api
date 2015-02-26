<?php namespace Rufy\RestApiBundle\Handler\Serializer;

use League\Fractal\Manager,
    League\Fractal\Resource\Item,
    League\Fractal\Resource\Collection;

use Rufy\RestApiBundle\Transformer\Fractal\Serializer\CustomSerializer,
    Rufy\RestApiBundle\Exception\InvalidFormException;

use FOS\RestBundle\Util\ExceptionWrapper;

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
        $this->initManager($resource);

        $resource = new Collection($resource, $this->transformer);

        return $this->fractalManager->createData($resource)->toJson();
    }

    private function initManager($resource)
    {
        if (is_array($resource) && 0 < count($resource))
            $resource   = current($resource);

        $this->resourceClassName        = 'Generic';

        if ($this->isRufyValidEntity($resource)) {

            $entity = get_class($resource);

            $dirs                               = explode('\\', $entity);
            $this->resourceClassName            = $dirs[count($dirs) - 1];

        } else if (is_a($resource, 'Rufy\RestApiBundle\Exception\InvalidFormException')) {

            /**
             * TODO
             * @deprecate
             */
            //$this->resourceClassName        = 'FormError';

        } else if (is_a($resource, 'FOS\RestBundle\Util\ExceptionWrapper')) {

            /**
             * @var $resource ExceptionWrapper
             */

            switch ($resource->getCode()) {

                case 400:
                    $this->resourceClassName        = 'FormError';
                    break;
            }
        }

        $this->fractalManager->setSerializer($this->customFractalSerializer);

        $this->transformer = $this->getTransformer();
    }

    private function isRufyValidEntity($resource)
    {
        if (is_object($resource) && FALSE !== ($class = get_class($resource)) && strstr($class, 'RestApiBundle\Entity'))
            return class_exists($class);

        return false;
    }

    private function getTransformer() {

        $class = static::TRANSFORMER_PATH.$this->resourceClassName.static::TRANSFORMER_SUFFIX;

        return new $class();

    }
}
