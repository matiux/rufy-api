<?php namespace Rufy\RestApiBundle\EventListener;

use Rufy\RestApiBundle\Controller\AuthenticatedFullyController;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException,
    Symfony\Component\HttpKernel\Event\FilterControllerEvent,
    Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AuthenticatedFullyListener
 * @package Rufy\RestApiBundle\EventListener
 *
 * TODO
 * Questo listener si occupa di verificare prima di ogni chiamata ai controller, che l'utente sia loggato
 * Si base è disabilitato in quanto il controllo sulla sicurezza è gestito dal file security.yml
 * Per abilitarlo, decommentare il codice nel file services.yml
 */
class AuthenticatedFullyListener
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct (ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        /*
         * $controller passato può essere una classe o una Closure. Non è frequente in Symfony ma può accadere.
         * Se è una classe, è in formato array
         */
        if (!is_array($controller)) {
            return;
        }

        if($controller[0] instanceof AuthenticatedFullyController) {
            if (!$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
                //throw new AccessDeniedException();
                throw new AccessDeniedHttpException();
        }
    }
}
