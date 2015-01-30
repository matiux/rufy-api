<?php namespace Rufy\RestApiBundle\Tests\Features\Contexts;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    private $_session;

    /**
     * @var \Rufy\RestApiBundle\Tests\Features\Contexts\ReservationContext
     */
    private $_reservationContext;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(Session $session)
    {
        //parent::__construct();

        $this->_session     = $session;
    }

    /**
     * @BeforeScenario
     * @param BeforeScenarioScope $scope
     */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment               = $scope->getEnvironment();
        $this->_reservationContext = $environment->getContext('Rufy\RestApiBundle\Tests\Features\Contexts\ReservationContext');
    }

}
