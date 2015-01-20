<?php namespace Rufy\RestApiBundle\Tests\Features\Contexts;

use Rufy\RestApiBundle\Utility\String;

abstract class RestContext
{
    const METHOD_DELETE     = 'DELETE';
    const METHOD_GET        = 'GET';
    const METHOD_POST       = 'POST';
    const METHOD_PUT        = 'PUT';

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $requestMethod;

    /**
     * @var int
     */
    protected $resource_id;

    /**
     * @var string
     */
    protected $resource;

    public function __construct()
    {
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

        $resource = new String($resource);

        // Cerco lo slash
        if ($resource->contains('\/')) {

            $els                = explode('/', $resource);
            $this->resource_id  = $els[1];
            $resource           = $els[0];
        }

        $this->resource         = (string) $resource;
    }
}
