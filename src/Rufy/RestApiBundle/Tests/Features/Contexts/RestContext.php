<?php namespace Rufy\RestApiBundle\Tests\Features\Contexts;

abstract class RestContext
{
    const METHOD_DELETE = 'DELETE';
    const METHOD_GET    = 'GET';
    const METHOD_POST   = 'POST';
    const METHOD_PUT    = 'PUT';

    /**
     * @var Rufy\RestApiBundle\Utility\String
     */
    private $_string;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $requestMethod;

    public function __construct($string)
    {
        $this->_string = $string;

        $this->baseUrl  = 'http://rufysf.local/api';
    }

    /**
     * @Given /^that I want to add an? new "([^"]*)"$/
     */
    public function thatIWantToAddANew($resource)
    {
        $this->requestMethod    = self::METHOD_POST;

        $this->setResource($resource);
    }

    private function setResource($resource) {

        $this->_string->set($resource);

        if ($this->_string->contains('\/')) {

            echo 'si';

            $els        = explode('/', $resource);

            $this->resource_id = $els[1];

            $resource   = $els[0];
        } else {

            echo 'no';
        }

        $this->resource         = $resource;
    }
}
