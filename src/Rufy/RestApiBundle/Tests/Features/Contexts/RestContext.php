<?php namespace Rufy\RestApiBundle\Tests\Features\Contexts;

use Guzzle\Http\Client;
use Rufy\RestApiBundle\Utility\String;

abstract class RestContext extends \PHPUnit_Framework_TestCase
{
    const METHOD_GET        = 'GET';

    protected $requestMethod;
    protected $resource_id;
    protected $resource;
    protected $response;
    protected $url;
    protected $client;
    protected $baseUrl;
    protected $params = [];

    public function __construct(array $parameters) {

        $this->client       = new Client();
        $this->baseUrl      = 'http://rufysf.local/api';
    }

    /**
     * @Given /^that I want to find a "([^"]*)"$/
     */
    public function thatIWantAResourceWithIdEqualTo($resource)
    {
        $this->requestMethod    = self::METHOD_GET;

        $this->setResource($resource);
    }

    private function setResource($resource) {

        if (strstr($resource, '/')) {

            $els        = explode('/', $resource);

            $this->resource_id = $els[1];

            $resource   = $els[0];
        }

        $this->resource         = $resource;
    }

    /**
     * @Given /^I request a resource$/
     */
    public function iRequestAResource()
    {
        $this->buildUrl("/{$this->resource}");

        $request            = $this->client->createRequest($this->requestMethod, $this->url, ['body' =>  json_encode($this->params)]);

        //$request->setBody(new StreamIn);
        $request->setHeader('Accept', 'application/vnd.rufy.v1+json');
        $request->setHeader('Content-Type', 'application/json');

        //echo $request->getUrl();

        $this->response     = $this->client->send($request);

        $this->assertNotEquals(null, $this->response, "The response is null");
        $this->assertTrue(is_a($this->response, 'Guzzle\Http\Message\Response'), 'The response is not of GuzzleHttp\Message\Response type');
    }

    protected function buildUrl($url) {

        $this->url = $this->baseUrl."$url";

        if (0 != $this->resource_id)
            $this->url .= "/".$this->resource_id;

    }

//    const METHOD_DELETE     = 'DELETE';
//
//    const METHOD_POST       = 'POST';
//    const METHOD_PUT        = 'PUT';
//
//    /**
//     * @var string
//     */
//    protected $baseUrl;
//
//    /**
//     * @var string
//     */
//    protected $requestMethod;
//
//    /**
//     * @var int
//     */
//    protected $resource_id;
//
//    /**
//     * @var string
//     */
//    protected $resource;
//
//    public function __construct()
//    {
//        $this->baseUrl  = 'http://rufysf.local/api';
//    }
//
//    /**
//     * @Given /^that I want to add an? new "([^"]*)"$/
//     */
//    public function thatIWantToAddANew($resource)
//    {
//        $this->requestMethod    = self::METHOD_POST;
//
//        $this->setResource($resource);
//    }
//
//    private function setResource($resource) {
//
//        $resource = new String($resource);
//
//        // Cerco lo slash
//        if ($resource->contains('\/')) {
//
//            $els                = explode('/', $resource);
//            $this->resource_id  = $els[1];
//            $resource           = $els[0];
//        }
//
//        $this->resource         = (string) $resource;
//    }
}
