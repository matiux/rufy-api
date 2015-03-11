<?php namespace Task;

use Exception;
use Mage\Task\AbstractTask;
use Mage\Task\ErrorWithMessageException;
use Mage\Task\SkipException;

class ComposerOptimize extends AbstractTask
{
    /**
     * Returns the Title of the Task
     * @return string
     */
    public function getName()
    {
        return 'Composer optimize';
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
        $command    = 'composer dump-autoload --optimize';
        $result     = $this->runCommandRemote($command);

        return $result;
    }
}
