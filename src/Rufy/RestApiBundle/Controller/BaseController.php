<?php namespace Rufy\RestApiBundle\Controller; 

use FOS\RestBundle\Controller\FOSRestController;

use Rufy\RestApiBundle\Model\AreaInterface,
    Rufy\RestApiBundle\Model\ReservationInterface,
    Rufy\RestApiBundle\Model\RestaurantInterface,
    Rufy\RestApiBundle\Model\EntityInterface;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaseController extends FOSRestController implements AuthenticatedFullyController
{
    /**
     * Con array_filter provo a esplodere i valori della queury string. Se ci sono virgole, e quindi più
     * valori, allora la query verrà assemblata con WHERE IN, altrimenti sarà un semplice WHERE
     *
     * @param $limit
     * @param $offset
     * @param $params
     * @param array $source
     */
    protected function prepareFilters(&$limit, &$offset, &$params, array $source) {

        $offset         = null == $source['offset'] ? 0 : $source['offset'];
        $limit          = $source['limit'];

        unset($source['limit'], $source['offset']);

        $params = array_filter($source, function(&$fValue) {

            if ($fValue != null) {

                $values = explode(',', $fValue);

                if (1 < count($values)) {

                    $fValue = $values;
                }

                return true;
            }

            return false;
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

    /**
     * @param $model
     * @param EntityInterface $resource
     * @param array $params
     * @return mixed
     */
    // protected function patchAction($model, EntityInterface $resource, array $params = null) {

    //     $params             = !$params ? $this->container->get('request')->request->all() : $params;
    //     $updatedResource    = $this->container->get("rufy_api.$model.handler")->patch($resource, $params);

    //     return $updatedResource;
    // }
    protected function patchAction($model, EntityInterface $resource, array $params = null) {

        $params             = !$params ? $this->container->get('request')->request->all() : $params;
        $updatedResource    = $this->container->get("rufy_api.$model.handler")->patch($resource, $params);

        return $updatedResource;
    }
}
