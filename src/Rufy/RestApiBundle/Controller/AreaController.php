<?php namespace Rufy\RestApiBundle\Controller;

use FOS\RestBundle\Request\ParamFetcherInterface,
    FOS\RestBundle\Controller\Annotations;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Rufy\RestApiBundle\Exception\InvalidFormException;

use Symfony\Component\Config\Definition\Exception\Exception,
    Symfony\Component\Security\Core\Exception\AccessDeniedException,
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
     *     403 = "Returned when you try to get an area of another restaurant",
     *     404 = "Returned when the area has not been found"
     *   }
     * )
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
