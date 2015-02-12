<?php

use Behat\Behat\Tester\Exception\PendingException,
    Behat\Behat\Context\Context,
    Behat\Behat\Context\SnippetAcceptingContext;

use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Rufy\RestApiBundle\Utility\String;

class RestContext implements Context, SnippetAcceptingContext, RestContextInterface
{
    /**
     * @var \Guzzle\Http\Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $baseApiUrl;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var string
     */
    protected $requestMethod;

    /**
     * @var string
     */
    protected $resource;

    /**
     * @var \Guzzle\Http\Message\Response
     */
    protected $response;

    protected $body;

    public function __construct($guzzleClient, $baseUrl)
    {
        $this->client           = $guzzleClient;
        $this->baseApiUrl       = $baseUrl;
    }

    /**
     * @Given im logged in with credentials :user :password
     */
    public function imLoggedInWithCredentials($user, $password)
    {
        $this->client->setDefaultOption('auth', array($user, $password, 'Basic'));

        //throw new PendingException();
    }

    /**
     * @Given that I want to find a :resource
     */
    public function thatIWantToFindA($resource)
    {
        $this->requestMethod    = self::METHOD_GET;

        $this->resource         = $resource;

        //throw new PendingException();
    }

    /**
     * @Given that I want to add a new :resource with values:
     */
    public function thatIWantToAddANewWithValues($resource, TableNode $table)
    {
        $this->requestMethod    = self::METHOD_POST;

        throw new PendingException();
    }

    /**
     * @When I request a resource
     */
    public function iRequestAResource()
    {
        $url                = $this->baseApiUrl.$this->resource;

        $request            = $this->client->createRequest($this->requestMethod, $url, ['body' =>  json_encode($this->params)]);

        $this->response     = $this->client->send($request);
        $this->body         = $this->response->json();

        PHPUnit_Framework_Assert::assertNotEquals(null, $this->response, "The response is null");
        PHPUnit_Framework_Assert::assertTrue(is_a($this->response, 'Guzzle\Http\Message\Response'), 'The response is not of GuzzleHttp\Message\Response type');

        //throw new PendingException();
    }

    /**
     * @Then the response status code should be :arg1
     */
    public function theResponseStatusCodeShouldBe($responseStatus)
    {

        PHPUnit_Framework_Assert::assertEquals($responseStatus, $this->response->getStatusCode(), 'The response status is not equal');

        //throw new PendingException();
    }

    /**
     * @Then the response type should be :arg1
     */
    public function theResponseTypeShouldBe($responseType)
    {
        PHPUnit_Framework_Assert::assertTrue($this->response->getHeader('content-type')->hasValue($responseType), 'The response status is not '.$responseType);

        //throw new PendingException();
    }

    /**
     * @Then the response contains key :arg1
     */
    public function theResponseContainsKey($key)
    {
        PHPUnit_Framework_Assert::assertArrayHasKey($key, $this->body);

        //throw new PendingException();
    }

    /**
     * @Then :arg1 contains:
     */
    public function contains($path, PyStringNode $strings)
    {
        $strings    = $strings->getStrings();
        $path       = new String($path);
        $array      = $path->pathToArray($this->body);

        foreach ($strings as $key) {

            PHPUnit_Framework_Assert::assertArrayHasKey($key, $array, "$key does not exists in $path");
        }

        //throw new PendingException();
    }

    /**
     * @Then :arg1 is a collection
     */
    public function isACollection($arg1)
    {
        $path       = new String($arg1);
        $array      = $path->pathToArray($this->body);

        PHPUnit_Framework_Assert::assertTrue(is_array($array));

        //throw new PendingException();
    }

    /**
     * @Then each :arg1 item contains:
     */
    public function eachItemContains($arg1, PyStringNode $strings)
    {
        $path       = new String($arg1);
        $strings    = $strings->getStrings();
        $array      = $path->pathToArray($this->body);

        foreach ($array as $item) {

            foreach ($strings as $key) {

                PHPUnit_Framework_Assert::assertArrayHasKey($key, $item, "$key does not exists in $path");
            }
        }

        //throw new PendingException();
    }
}
