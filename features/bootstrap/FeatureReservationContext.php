<?php

class FeatureReservationContext extends RestContext
{
    public function __construct($testClient, $baseUrl)
    {
        parent::__construct($testClient, $baseUrl);
    }

    /**
     * @Given that I prepare database
     */
    public function thatIPrepareDatabase()
    {
        exec('php app/console doctrine:schema:drop --force --env=test');
        exec('php app/console doctrine:schema:update --env=test --force');
        exec('php app/console doctrine:fixtures:load --env=test --no-interaction');
    }

    /**
     * @Given that im logged in with credentials :user :password
     */
    public function imLoggedInWithCredentials($user, $password)
    {
        $this->user         = $user;
        $this->password     = $password;
    }

//    /**
//     * @Given that I want clear the database
//     */
//    public function thatIWantClearTheDatabase()
//    {
//        //$this->em->getEventManager()->addEventSubscriber(new \Gedmo\SoftDeleteable\SoftDeleteableListener());
//        $this->em->remove($this->em->getReference('RufyRestApiBundle:Reservation', 5));
//        $this->em->flush();
//
//        //throw new PendingException();
//    }
}
