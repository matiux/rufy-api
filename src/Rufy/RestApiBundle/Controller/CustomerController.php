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

    /**
     * Get single Customer.
     *
     * @ApiDoc(
     *  description = "Gets a Customer for a given id",
     *  output = "Rufy\RestApiBundle\Entity\Customer",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Customer ID"
     *      }
     *  },
     *
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     403 = "Returned when you try to get a customer of another restaurant",
     *     404 = "Returned when the customer has not been found"
     *   }
     * )
     *
     * @param int $id Customer id
     *
     * @return json
     *
     * @throws NotFoundHttpException when customer doesn't exist
     * @throws AccessDeniedException when role is not allowed
     */
    public function getCustomerAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
            throw new AccessDeniedException();

        $customer = $this->getOr404($id, 'customer');

        return $customer;
    }

    /**
     * Update existing customer
     *
     * @ApiDoc(
     *   input = "Rufy\RestApiBundle\Form\CustomerType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     403 = "Returned when you try to update a customer of another restaurant",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @param int $id the customer id
     *
     * @return FormTypeInterface
     *
     * @throws NotFoundHttpException when Customer doesn't exist
     */
    public function patchCustomerAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
            throw new AccessDeniedException();

        try {

            $customer = $this->container->get('rufy_api.customer.handler')->patch(
                $this->getOr404($id, 'customer'),
                $this->container->get('request')->request->all()
            );

            return $this->view($customer, 204);

        } catch(InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Delete existing customer
     *
     * @ApiDoc(
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Customer ID"
     *      }
     *  },
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the customer has not been found",
     *     403 = "Returned when you try to delete a customer of another restaurant"
     *   }
     * )
     *
     * @param int $id Customer id
     *
     *
     * @throws NotFoundHttpException when customer doesn't exist
     * @throws AccessDeniedException when role is not allowed
     */
    public function deleteCustomerAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
            throw new AccessDeniedException();

        $customer = $this->getOr404($id, 'customer');

        $this->container->get('rufy_api.customer.handler')->delete($customer);
    }
}
