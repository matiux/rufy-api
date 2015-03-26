<?php namespace Rufy\RestApiBundle\Controller;

use FOS\RestBundle\Request\ParamFetcherInterface,
    FOS\RestBundle\Controller\Annotations;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AreaController extends BaseController
{
    /**
     * Get single Area.
     *
     * @ApiDoc(
     *  description = "Gets an Area for a given id",
     *  output = "Rufy\RestApiBundle\Entity\Area",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="The area ID"
     *      }
     *  },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the area is not found"
     *   }
     * )
     *
     * @param int $id Area id
     *
     * @return json
     *
     * @throws NotFoundHttpException when area not exist
     * @throws AccessDeniedException when role is not allowed
     */
    public function getAreaAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
            throw new AccessDeniedException();

        $area = $this->getOr404($id, 'area');

        return $area;
    }
}
