<?php

use Behat\Behat\Tester\Exception\PendingException;

use Behat\Gherkin\Node\PyStringNode;

use Rufy\RestApiBundle\Utility\String;

class FeatureReservationContext extends RestContext
{
    public function __construct($guzzleClient, $baseUrl)
    {
        parent::__construct($guzzleClient, $baseUrl);
    }
}
