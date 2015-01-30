<?php namespace Rufy\RestApiBundle\Response\View;

use FOS\RestBundle\View\View,
    FOS\RestBundle\View\ViewHandler;

use League\Fractal\Resource\Item;

use Rufy\RestApiBundle\Transformer\Fractal\Serializer\CustomSerializer;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

use SamJ\FractalBundle\Manager;

final class JsonViewHandler
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

        $this->_fractalManager->setSerializer($this->_customFractalSerializer);

        /**
         * TODO
         * Sistemare
         */
//        if (Input::get('include'))
//            $this->fractalManager->parseIncludes(Input::get('include'));

        $this->_transformer          = $this->getTransformer();

        $resource                   = new Item($view->getData(), $this->_transformer);

        return new Response($this->_fractalManager->createData($resource)->toJson(), 200, $view->getHeaders());
    }

    private function setResourceType($entity) {

        $this->_resourceType             = $entity;
        $dirs                           = explode('\\', $entity);
        $this->_resourceClassName        = $dirs[count($dirs) - 1];
    }

    private function getTransformer() {

        $class = static::TRANSFORMER_PATH.$this->_resourceClassName.'Transformer';

        return new $class();

    }
}
