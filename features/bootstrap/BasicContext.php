<?php 

class BasicContext extends RestContext
{
    /**
     * @Given that im logged in with credentials :user :password
     */
    public function imLoggedInWithCredentials($user, $password)
    {
        $this->user         = $user;
        $this->password     = $password;
    }

    /**
     * @Given that I want complete the test
     */
    public function thatIWantCompleteTheTest()
    {
        unlink('features/data/test.lock');
    }
}
