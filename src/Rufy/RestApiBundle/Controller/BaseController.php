<?php namespace Rufy\RestApiBundle\Controller; 

use FOS\RestBundle\Controller\FOSRestController;

class BaseController extends FOSRestController
{
    protected function prepareFilters(&$limit, &$offset, &$params, $source) {

    }
}
