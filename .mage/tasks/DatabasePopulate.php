<?php namespace Task;

use Exception;
use Mage\Task\AbstractTask;
use Mage\Task\ErrorWithMessageException;
use Mage\Task\SkipException;

class DatabasePopulate extends AbstractTask
{
    /**
     * Returns the Title of the Task
     * @return string
     */
    public function getName()
    {
        return 'Database populate';
    }

    /**
     * Runs the task
     *
     * @return boolean
     * @throws Exception
     * @throws ErrorWithMessageException
     * @throws SkipException
     */
    public function run()
    {
        $command    = 'php app/console doctrine:fixtures:load';
        $result     = $this->runCommandRemote($command);

        return $result;
    }
}
