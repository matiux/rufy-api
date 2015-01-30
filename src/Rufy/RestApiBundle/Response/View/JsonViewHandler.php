<?php namespace Rufy\RestApiBundle\Response\View;

use FOS\RestBundle\View\View,
    FOS\RestBundle\View\ViewHandler;

use League\Fractal\Resource\Item;
use Rufy\RestApiBundle\Transformer\Serializer\CustomSerializer;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

use SamJ\FractalBundle\Manager;

final class JsonViewHandler
{
    const TRANSFORMER_PATH = 'Rufy\RestApiBundle\Transformer\\';

    private $resourceType;
    private $resourceClassName;
    private $transformer;

    public function __construct(Manager $fractalManager) {

        $this->fractalManager = $fractalManager;
    }

    /**
     * @param ViewHandler $viewHandler
     * @param View $view
     * @param Request $request
     * @param string $format
     *
     * @return Response
     */
    public function createResponse(ViewHandler $handler, View $view, Request $request, $format)
    {
        $this->setResourceType(get_class($view->getData()));

        $this->fractalManager->setSerializer(new CustomSerializer());

//        if (Input::get('include'))
//            $this->fractalManager->parseIncludes(Input::get('include'));

        $this->transformer   = $this->getTransformer();

        $resource                   = new Item($view->getData(), new $this->transformer());

        //return new Response($data, 200, $view->getHeaders());
        return $this->fractalManager->createData($resource);
    }

    private function setResourceType($entity) {

        $this->resourceType             = $entity;
        $dirs                           = explode('\\', $entity);
        $this->resourceClassName        = $dirs[count($dirs) - 1];
    }

    private function getTransformer() {

        return static::TRANSFORMER_PATH.$this->resourceClassName.'Transformer';;

        //switch

        //"Rufy\\Data\\Transformers\\".$this->_obj->getClassName().'Transformer';

        //static::TRANSFORMER_PATH
    }
}
