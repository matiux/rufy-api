<?php namespace Rufy\RestApiBundle\Controller; 

use FOS\RestBundle\Controller\FOSRestController;

class BaseController extends FOSRestController
{
    protected function prepareFilters(&$limit, &$offset, &$params, array $source) {

        $offset         = null == $source['offset'] ? 0 : $source['offset'];
        $limit          = $source['limit'];

        unset($source['limit'], $source['offset']);

        $params = array_filter($source, function($fValue) {

            return $fValue != null;

        });
    }
}
