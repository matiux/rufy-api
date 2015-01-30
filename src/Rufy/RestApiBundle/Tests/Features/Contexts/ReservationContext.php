<?php namespace Rufy\RestApiBundle\Tests\Features\Contexts; 

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;

class ReservationContext extends RestContext implements Context, SnippetAcceptingContext
{
    public function __construct(array $parameters = array()) {

        parent::__construct($parameters);
    }
}
