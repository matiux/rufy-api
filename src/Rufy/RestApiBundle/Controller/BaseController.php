<?php namespace Rufy\RestApiBundle\Controller; 

use FOS\RestBundle\Controller\FOSRestController;

use Rufy\RestApiBundle\Model\AreaInterface,
    Rufy\RestApiBundle\Model\ReservationInterface,
    Rufy\RestApiBundle\Model\RestaurantInterface;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaseController extends FOSRestController implements AuthenticatedFullyController
{
    protected function prepareFilters(&$limit, &$offset, &$params, array $source) {

        $offset         = null == $source['offset'] ? 0 : $source['offset'];
        $limit          = $source['limit'];

        unset($source['limit'], $source['offset']);

        $params = array_filter($source, function($fValue) {

            return $fValue != null;

        });
    }

    /**
     * Fetch a Entity or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return RestaurantInterface|AreaInterface|ReservationInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id, $model)
    {
        if (!($entity = $this->get("rufy_api.$model.handler")->get($id))) {

            throw new NotFoundHttpException(sprintf("'The $model '%s' was not found.'", $id));
        }

        return $entity;
    }
}
