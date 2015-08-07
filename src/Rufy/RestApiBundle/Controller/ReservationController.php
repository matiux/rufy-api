<?php namespace Rufy\RestApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;

use Rufy\RestApiBundle\Entity\Reservation;
use Rufy\RestApiBundle\Exception\InvalidFormException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Security\Core\Exception\AccessDeniedException,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException,
    Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ReservationController extends BaseController
{
    /**
     * Get single Reservation.
     *
     * @param Reservation $reservation
     *
     * @return array
     * @View()
     * @ParamConverter("reservation", class="Rufy\RestApiBundle\Entity\Reservation")
     */
    public function getReservationAction(Reservation $reservation)
    {
        $this->denyAccessUnlessGranted('ROLE_READER', null, 'Non si può accedere a questa risorsa!');

        //$reservation = $this->getOr404($id, 'reservation');

        return $reservation;
    }

    /**
     * Create a Reservation from the sended data.
     *
     * @param Request $request
     * @return array|\FOS\RestBundle\View\View|null if user is not logged in
     */
    public function postReservationAction(Request $request)
    {
        /**
         * Oppure:
         * $this->container->get('request')->request
         * $this->container->get('request')->request->all()
         */

        //$this->denyAccessUnlessGranted('ROLE_USER', null, 'Non si può accedere a questa risorsa!');

        try {

            $this->prepareRequest($request);

            $reservation = $this->get('rufy_api.reservation.handler')->post($request);

            return $this->view($reservation, 201);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
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

            $params         = $this->prepareRequest($this->container->get('request')->request->all());
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
     * @param int $id Reservation id
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

    private function prepareRequest(Request $request)
    {
        if ($request->request->get('id')) {

            $request->request->remove('id');
        }

        $ro = $request->request->get('reservationOptions');

        if ($ro && is_array($ro)) {

            $o = [];

            foreach($ro as $resOpts) {

                $o[] = $resOpts['id'];
            }

            $request->request->set('reservationOptions', $o);
        }
    }
}
