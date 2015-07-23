<?php namespace Rufy\RestApiBundle\Controller;

use FOS\RestBundle\Request\ParamFetcherInterface,
    FOS\RestBundle\Controller\Annotations;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Rufy\RestApiBundle\Entity\Customer;
use Rufy\RestApiBundle\Entity\Reservation;
use Rufy\RestApiBundle\Exception\InvalidFormException;

use Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException,
    Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ReservationController extends BaseController
{
    /**
     * Get single Reservation.
     *
     * @ApiDoc(
     *  description = "Gets a Reservation for a given id",
     *  output = "Rufy\RestApiBundle\Entity\Reservation",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Reservation ID"
     *      }
     *  },
     *
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     403 = "Returned when you try to get a reservation of another restaurant",
     *     404 = "Returned when the reservation has not been found"
     *   }
     * )
     *
     * @param int $id Reservation id
     *
     * @return json
     *
     * @throws NotFoundHttpException when reservation doesn't exist
     * @throws AccessDeniedException when role is not allowed
     */
    public function getReservationAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_READER', null, 'Non si può accedere a questa risorsa!');

        $reservation = $this->getOr404($id, 'reservation');

        return $reservation;
    }

    /**
     * Create a Reservation from the sended data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new reservation from the sended data.",
     *   input = "Rufy\RestApiBundle\Form\ReservationType",
     *   output = "Rufy\RestApiBundle\Entity\Reservation",
     *   statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when the data is invalid or non-existent",
     *     403 = "Returned when relationships are not allowed"
     *   }
     * )
     *
     * @throws AccessDeniedException if user is not logged in
     */
    public function postReservationAction()
    {
//        $m = $this->get('memcached');
//
////         $m->set('int', 99);
////         $m->set('string', 'a simple string');
////         $m->set('array', array(11, 12));
//
//        $result = $m->getMulti(array('int', 'string', 'array', 'name', 'surname'), $cas);
//
//        echo '<pre>';
//        print_r($result);
//        echo '</pre>';
//
//        var_dump($cas);
//
//        die();  die();

        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Non si può accedere a questa risorsa!');

        try {

            /**
             * Preparo i parametri
             */
            $params         = $this->prepareParams($this->container->get('request')->request->all());

            /**
             * Gestisco il salvataggio del Customer ma senza effettuare il flush
             * Così sfrutto la transazione per non salvarlo se la Reservation non andrà a buon fine
             */
            $this->saveWithcustomerCheck($params, $customer);

            /**
             * @var $reservation Reservation
             */
            $reservation                = $this->get('rufy_api.reservation.handler')->post($params, true);

            $this->get('rufy_api.reservation.handler')->bindCustomerToReservation($reservation, $customer);

            return $this->view($reservation, 201);

            //return $this->handleView($view);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    private function saveWithcustomerCheck(array &$params, &$customer)
    {
        if (is_array($params['customer'])) {

            /**
             * @var $customer Customer
             */
            $customer               = $this->get('rufy_api.customer.handler')->post($params['customer'], true);
            $customer               = $customer->getId() ?: $customer;

        } else {

            $customer                   = $params['customer'];
        }

        unset($params['customer']);
    }

    private function updateWithcustomerCheck(array &$params)
    {
        if (isset($params['customer']) && is_array($params['customer'])) {

            $data           = $params['customer'];

            if (null == ($customerId = @$data['id']))
                throw new BadRequestHttpException(sprintf("The id attribute of the customer was not specified"));

            unset($params['customer']);
            unset($data['id']);

            $this->container->get('rufy_api.customer.handler')->patch($this->getOr404($customerId, 'customer'), $data);
        }
    }

    /**
     * Update existing reservation from the submitted data
     *
     * @ApiDoc(
     *   input = "Rufy\RestApiBundle\Form\ReservationType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors",
     *     403 = "Returned when the user haven't the right access"
     *   }
     * )
     *
     * @param int $id the reservation id
     *
     * @return FormTypeInterface
     *
     * @throws NotFoundHttpException when Reservation doesn't exist
     */
    public function patchReservationAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Non si può accedere a questa risorsa!');

        try {

            $params         = $this->prepareParams($this->container->get('request')->request->all());
            $this->updateWithcustomerCheck($params);

            $reservation    = $this->patchAction('reservation', $this->getOr404($id, 'reservation'), $params);

            return $this->view($reservation, 204);

        } catch(InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    public function putReservationAction($id)
    {
        return $this->patchReservationAction($id);
    }

    /**
     * Delete existing reservation
     *
     * @ApiDoc(
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Reservation ID"
     *      }
     *  },
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the reservation has not been found",
     *     403 = "Returned when you try to delete a reservation of another restaurant"
     *   }
     * )
     *
     * @param int $id Reservation id
     *
     *
     * @throws NotFoundHttpException when reservation doesn't exist
     * @throws AccessDeniedException when role is not allowed
     */
    public function deleteReservationAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Non si può accedere a questa risorsa!');

        $reservation = $this->getOr404($id, 'reservation');

        $this->container->get('rufy_api.reservation.handler')->delete($reservation);
    }

    private function prepareParams($params)
    {
        if (isset($params['id'])) {

            unset($params['id']);
        }

        if (isset($params['reservationOptions']) && is_array(current($params['reservationOptions']))) {

            $o = [];

            foreach($params['reservationOptions'] as $resOpts) {

                $o[] = $resOpts['id'];
            }

            $params['reservationOptions'] = $o;
        }

        return $params;
    }
}
