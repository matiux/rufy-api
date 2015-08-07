<?php namespace Rufy\RestApiBundle\Controller;

use FOS\RestBundle\Request\ParamFetcherInterface,
    FOS\RestBundle\Controller\Annotations;

use Rufy\RestApiBundle\Exception\InvalidFormException;

use Symfony\Component\Config\Definition\Exception\Exception,
    Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AreaController extends BaseController
{
    /**
     * Create an Area
     *
     * @throws AccessDeniedException if user is not logged in
     */
    public function postAreaAction()
    {
        $this->denyAccessUnlessGranted('ROLE_OWNER', null, 'Non si può accedere a questa risorsa!');

        try {

            $params         = $this->container->get('request')->request->all();
            $area           = $this->get('rufy_api.area.handler')->post($params);

            return $this->view($area, 201);

            //return $this->handleView($view);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Get single Area.
     *
     * @param int $id Area id
     *
     * @return json
     *
     * @throws NotFoundHttpException when area doesn't exist
     * @throws AccessDeniedException when role is not allowed
     */
    public function getAreaAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_READER', null, 'Non si può accedere a questa risorsa!');

        $area = $this->getOr404($id, 'area');

        return $area;
    }
}
