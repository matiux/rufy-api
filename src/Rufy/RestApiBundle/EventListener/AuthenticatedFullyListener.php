<?php namespace Rufy\RestApiBundle\EventListener;

use Rufy\RestApiBundle\Controller\AuthenticatedFullyController;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException,
    Symfony\Component\HttpKernel\Event\FilterControllerEvent,
    Symfony\Component\DependencyInjection\ContainerInterface;

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
