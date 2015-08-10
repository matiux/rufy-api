<?php namespace Rufy\RestApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations;

use FOS\RestBundle\Controller\Annotations\View;
use Rufy\RestApiBundle\Exception\InvalidFormException;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AreaController extends BaseController
{
    /**
     * @param Request $request
     * @View()
     * @return array
     */
    public function postAreaAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_OWNER', null, 'Non si può accedere a questa risorsa!');

        try {

            /**
             * TODO
             * Da testare
             */
            //$this->prepareRequest($request);

            $area = $this->get('rufy_api.area.handler')->post($request);

            return $this->view($area, 201);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Get single Area.
     *
     * @param int $reservationId
     *
     * @return array
     * @View()
     */
    public function getAreaAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_READER', null, 'Non si può accedere a questa risorsa!');

        $area = $this->getOr404($id, 'area');

        return $area;
    }
}
