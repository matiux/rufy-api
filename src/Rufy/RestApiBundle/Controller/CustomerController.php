<?php namespace Rufy\RestApiBundle\Controller;

use FOS\RestBundle\Request\ParamFetcherInterface,
    FOS\RestBundle\Controller\Annotations;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Rufy\RestApiBundle\Exception\InvalidFormException;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerController extends BaseController
{
    /**
     * Create a Customer from the sended data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new customer from the sended data.",
     *   input = "Rufy\RestApiBundle\Form\CustomerType",
     *   output = "Rufy\RestApiBundle\Entity\Customer",
     *   statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when the data is invalid or non-existent",
     *     403 = "Returned when relationships are not allowed"
     *   }
     * )
     *
     * @throws AccessDeniedException if user is not logged in
     */
    public function postCustomerAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
            throw new AccessDeniedException();

        try {

            $customer    = $this->get('rufy_api.customer.handler')->post($this->container->get('request')->request->all());

            return $this->view($customer, 201);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

//    /**
//     * Update existing customer
//     *
//     * @ApiDoc(
//     *   input = "Rufy\RestApiBundle\Form\CustomerType",
//     *   statusCodes = {
//     *     204 = "Returned when successful",
//     *     400 = "Returned when the form has errors"
//     *   }
//     * )
//     *
//     * @param int $id the reservation id
//     *
//     * @return FormTypeInterface
//     *
//     * @throws NotFoundHttpException when Reservation not exist
//     */
//    public function patchReservationAction($id)
//    {
//        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
//            throw new AccessDeniedException();
//
//        try {
//
//            $reservation = $this->container->get('rufy_api.reservation.handler')->patch(
//                $this->getOr404($id, 'reservation'),
//                $this->container->get('request')->request->all()
//            );
//
//            return $this->view($reservation, 204);
//
//        } catch(InvalidFormException $exception) {
//
//            return $exception->getForm();
//        }
//    }
}
