<?php namespace Rufy\RestApiBundle\Tests\Features\Contexts;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Symfony\Component\HttpFoundation\Session\Session;
use \Rufy\RestApiBundle\Utility\String;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RestContext implements Context, SnippetAcceptingContext
{
    private $_session;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(Session $session)
    {
        parent::__construct();

        $this->_session     = $session;
    }
}
