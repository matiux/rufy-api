<?php namespace Task;

use Exception;
use Mage\Task\AbstractTask;
use Mage\Task\ErrorWithMessageException;
use Mage\Task\SkipException;

class ClearCache extends AbstractTask
{
    /**
     * Returns the Title of the Task
     * @return string
     */
    public function getName()
    {
        return 'Hard cache and log deleting';
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
        $command    = 'rm -fr app/cache/dev/* && rm -fr app/cache/test/* && rm -fr app/cache/prod/* && rm app/logs/*';
        $result     = $this->runCommandRemote($command);

        return $result;
    }
}
