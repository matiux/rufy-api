<?php namespace Rufy\RestApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CommandController extends Controller
{
    public function dbSeedAction()
    {
        $rootDir = $this->get('kernel')->getRootDir();

        exec("php $rootDir/console doctrine:fixtures:load --no-interaction");

        return new Response('Database rigenerato');
    }
}
