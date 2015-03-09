<?php namespace Task;

use Exception;
use Mage\Task\AbstractTask;
use Mage\Task\ErrorWithMessageException;
use Mage\Task\SkipException;

class PermissionsSetDirs extends AbstractTask
{
    /**
     * Returns the Title of the Task
     * @return string
     */
    public function getName()
    {
        return 'Set new cache and log directories';
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
        $result     = $this->runCommandRemote("HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`");

        if ($result) {

            $result = $this->runCommandRemote('setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs');

            if ($result) {

                $result = $this->runCommandRemote('setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs');

                return $result;

            } else {

                return $result;
            }

        } else {

            return $result;
        }

    }
}
