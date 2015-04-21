<?php

use Behat\Behat\Tester\Exception\PendingException,
    Behat\Behat\Context\Context,
    Behat\Behat\Context\SnippetAcceptingContext,
    Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Doctrine\ORM\EntityManager;

use \Symfony\Bundle\FrameworkBundle\Client;

use Rufy\RestApiBundle\Utility\String;

class RestContext implements Context, SnippetAcceptingContext, RestContextInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $baseApiUrl;

    /**
     * @var string
     */
    protected $requestMethod;

    /**
     * @var string
     */
    protected $resource;

    protected $body;

    /**
     * @var array
     */
    protected $toSendData = [];

    protected $user;
    protected $password;

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(Client $testClient, $baseUrl)
    {
        $this->client           = $testClient;
        $this->baseApiUrl       = $baseUrl;

        if (!file_exists('features/data/test.lock')) {

            fopen('features/data/test.lock', 'w');

            /**
             * Preparo il database
             */
            exec('php app/console doctrine:schema:drop --force --env=test');
            exec('php app/console doctrine:schema:update --env=test --force');
            exec('php app/console doctrine:fixtures:load --env=test --no-interaction');
        }
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
        $this->resource         = $resource;
        $this->toSendData       = $this->prepareToSendData($table->getColumnsHash());
    }

    /**
     * @Given that I want delete a reservation :arg1:
     */
    public function thatIWantDeleteAReservation($resource)
    {
        $this->requestMethod    = self::METHOD_DELETE;
        $this->resource         = $resource;
    }

    /**
     * @Given that I want update an existing :arg1 with values:
     */
    public function thatIWantUpdateAnExistingWithValues($resource, TableNode $table)
    {
        $this->requestMethod    = self::METHOD_PATCH;
        $this->resource         = $resource;
        $this->toSendData       = $this->prepareToSendData($table->getColumnsHash());
    }

    private function prepareToSendData($toSendData)
    {
        $postArray = [];

        foreach ($toSendData as $index => $data) {

            if ('reservationOptions' == $data['field'])
                $data['value'] = explode(',', $data['value']);

            $postArray[$data['field']] = $data['value'];
        }

        return json_encode($postArray);
    }

    /**
     * @When I request a resource
     */
    public function iRequestAResource()
    {
        $url                = $this->baseApiUrl.$this->resource;

        if ('POST' == $this->requestMethod) {

            $this->client->request(
                'POST',
                $url,
                array(),
                array(),
                array(
                    'PHP_AUTH_USER'     => $this->user,
                    'PHP_AUTH_PW'       => $this->password,
                    'CONTENT_TYPE'      => 'application/json'
                ),
                $this->toSendData);

        } else if ('PATCH' == $this->requestMethod) {

            $this->client->request(
                'PATCH',
                $url,
                array(),
                array(),
                array(
                    'PHP_AUTH_USER' => $this->user,
                    'PHP_AUTH_PW'   => $this->password,
                    'CONTENT_TYPE' => 'application/json'
                ),
                $this->toSendData);


        } else if ('DELETE' == $this->requestMethod) {

            $this->client->request(
                'DELETE',
                $url,
                array(),
                array(),
                array(
                    'PHP_AUTH_USER' => $this->user,
                    'PHP_AUTH_PW'   => $this->password
                )
            );
        }
        else {

            $this->client->request('GET', $url, array(), array(), array(

                'PHP_AUTH_USER' => $this->user,
                'PHP_AUTH_PW'   => $this->password,
            ));
        }

        $this->body         = json_decode($this->client->getResponse()->getContent(), true);

        PHPUnit_Framework_Assert::assertNotEquals(null, $this->client->getResponse(), "The response is null");
        PHPUnit_Framework_Assert::assertTrue(is_a($this->client->getResponse(), 'Symfony\Component\HttpFoundation\Response'), 'The response is not of GuzzleHttp\Message\Response type');

        //throw new PendingException();
    }

    /**
     * @Then the response status code should be :arg1
     */
    public function theResponseStatusCodeShouldBe($responseStatus)
    {

        PHPUnit_Framework_Assert::assertEquals($responseStatus, $this->client->getResponse()->getStatusCode(), 'The response status is not equal');

        //throw new PendingException();
    }

    /**
     * @Then the response type should be :arg1
     */
    public function theResponseTypeShouldBe($responseType)
    {
        PHPUnit_Framework_Assert::assertTrue($this->client->getResponse()->headers->contains('content-type', $responseType), 'The response status is not '.$responseType);

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
    public function containsArgs($path, PyStringNode $strings)
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
     * @Then :arg1 doesn't contains:
     */
    public function doesnTContains($path, PyStringNode $strings)
    {
        $strings    = $strings->getStrings();
        $path       = new String($path);
        $array      = $path->pathToArray($this->body);

        foreach ($strings as $key) {

            PHPUnit_Framework_Assert::assertArrayNotHasKey($key, $array, "$key does not exists in $path");
        }
    }

    /**
     * @Then each :arg1 item doesn't contains:
     */
    public function eachItemDoesnTContains($arg1, PyStringNode $strings)
    {
        $path       = new String($arg1);
        $strings    = $strings->getStrings();
        $array      = $path->pathToArray($this->body);

        foreach ($array as $item) {

            foreach ($strings as $key) {

                PHPUnit_Framework_Assert::assertArrayNotHasKey($key, $item, "$key does not exists in $path");
            }
        }
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
