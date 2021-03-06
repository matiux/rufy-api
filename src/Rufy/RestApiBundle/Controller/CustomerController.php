<?php namespace Rufy\RestApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations,
    FOS\RestBundle\Controller\Annotations\View;

use Rufy\RestApiBundle\Exception\InvalidFormException;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerController extends BaseController
{
    /**
     * Create a Customer from the sended data.
     *
     * @param Request $request
     * @View()
     * @return array
     */
    public function postCustomerAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Non si può accedere a questa risorsa!');

        try {

            $customer = $this->get('rufy_api.customer.handler')->post($request);

            return $this->view($customer, 201);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Get single Customer.
     *
     * @param int $id Customer id
     *
     * @return array
     * @View()
     */
    public function getCustomerAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_READER', null, 'Non si può accedere a questa risorsa!');

        $customer = $this->getOr404($id, 'customer');

        return $customer;
    }

    /**
     * Update existing customer
     *
     * @param int $id the customer id
     * @param Request $request
     *
     * @View()
     *
     * @return array
     */
    public function patchCustomerAction($id, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Non si può accedere a questa risorsa!');

        try {

            $customer = $this->patchAction('customer', $this->getOr404($id, 'customer'), $request);

            return $this->view($customer, 204);

        } catch(InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Delete existing customer
     *
     * @param int $id Customer id
     *
     * @return \FOS\RestBundle\View\View
     */
    public function deleteCustomerAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_OWNER', null, 'Non si può accedere a questa risorsa!');

        $customer = $this->getOr404($id, 'customer');

        $this->container->get('rufy_api.customer.handler')->delete($customer);

        return $this->view($customer, 204);
    }
}
