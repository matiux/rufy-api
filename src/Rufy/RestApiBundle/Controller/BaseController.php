<?php namespace Rufy\RestApiBundle\Controller; 

use FOS\RestBundle\Controller\FOSRestController;

use Rufy\RestApiBundle\Model\EntityInterface;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        foreach ($source as $fKey => $fValue) {

            if (null == $fValue) {
                continue;
            }

            if (false !== strpos($fKey, '_')) {
                $fKey = str_replace('_', '.', $fKey);
            }

            $values         = explode(',', $fValue);

            $params[$fKey]  = 1 < count($values) ? $values: $fValue;
        }

//        $params = array_filter($source, function(&$fValue, $fKey) {
//
//            if ($fValue != null) {
//
//                $values = explode(',', $fValue);
//
//                if (1 < count($values)) {
//
//                    $fValue = $values;
//                }
//
//                return true;
//            }
//
//            return false;
//        });

    }

    /**
     * Fetch a Entity or throw an 404 Exception.
     *
     * @param int $id               - L'id del modello da aggiornare
     * @param string $modelName     - Il modello per l'handler
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id, $modelName = null)
    {
        /**
         * TODO
         * $model si potrebbe impostare di default a null. Se null allora lo si potrebbe auto dedurre dalla classe
         * che sta effettuando la chiama al metodo
         */

        if (!($entity = $this->get("rufy_api.$modelName.handler")->get($id))) {

            throw new NotFoundHttpException(sprintf("'The $modelName '%s' was not found.'", $id));
        }

        return $entity;
    }


    // protected function patchAction($model, EntityInterface $resource, array $params = null) {

    //     $params             = !$params ? $this->container->get('request')->request->all() : $params;
    //     $updatedResource    = $this->container->get("rufy_api.$model.handler")->patch($resource, $params);

    //     return $updatedResource;
    // }

    /**
     * @param $modelName                - Il modello per l'handler
     * @param EntityInterface $model    - Il modello da aggiornare
     * @param Request $request          - La request con i dati per l'aggiornamento
     * @return mixed
     */
    protected function patchAction($modelName, EntityInterface $model, Request $request) {

        $updatedResource    = $this->container->get("rufy_api.$modelName.handler")->patch($model, $request);

        return $updatedResource;
    }
}
