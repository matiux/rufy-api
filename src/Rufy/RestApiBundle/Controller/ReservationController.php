<?php namespace Rufy\RestApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View,
    FOS\RestBundle\Controller\Annotations;

use Rufy\RestApiBundle\Exception\InvalidFormException;

use Symfony\Component\HttpFoundation\Request;

class ReservationController extends BaseController
{
    /**
     * Get single Reservation.
     *
     * Non uso ParamConverter dato che devo prendere solo le Reservatione valide per l'utente
     * che le richiede. Potrei creare un converter ad hoc ma per ora uso l'handler e così uso
     * il voter
     *
     * @param int $reservationId
     *
     * @return array
     * @View()
     */
    public function getReservationAction($reservationId)
    {
        $this->denyAccessUnlessGranted('ROLE_READER', null, 'Non si può accedere a questa risorsa!');

        $reservation = $this->getOr404($reservationId, 'reservation');

        return $reservation;
    }

    /**
     * Create a Reservation from the sended data.
     *
     * @param Request $request
     * @View()
     * @return array
     */
    public function postReservationAction(Request $request)
    {
        /**
         * Oppure:
         * $this->container->get('request')->request
         * $this->container->get('request')->request->all()
         */

        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Non si può accedere a questa risorsa!');

        try {

            /**
             * TODO
             * Da testare
             */
            $this->prepareRequest($request);

            $reservation = $this->get('rufy_api.reservation.handler')->post($request);

            return $this->view($reservation, 201);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing reservation from the submitted data
     *
     * @param int $reservationId
     * @param Request $request
     * 
     * @View()
     * 
     * @return array
     */
    public function patchReservationAction($reservationId, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Non si può accedere a questa risorsa!');

        try {

            $this->prepareRequest($request);

            $reservation = $this->patchAction('reservation', $this->getOr404($reservationId, 'reservation'), $request);

            return $this->view($reservation, 204);

        } catch(InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing reservation from the submitted data
     *
     * @param int $reservationId
     * @param Request $request
     *
     * @View()
     *
     * @return array
     */
    public function putReservationAction($reservationId, Request $request)
    {
        return $this->patchReservationAction($reservationId, $request);
    }


    /**
     * @param $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteReservationAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Non si può accedere a questa risorsa!');

        $reservation = $this->getOr404($id, 'reservation');

        $this->container->get('rufy_api.reservation.handler')->delete($reservation);

        return $this->view($reservation, 204);
    }

    private function prepareRequest(Request $request)
    {
        if ($request->request->get('id')) {

            $request->request->remove('id');
        }

        if ($request->request->get('date') && strstr($request->request->get('date'), '/')) {

            $date = new \DateTime($request->request->get('date'));
            $request->request->set('date', $date->format('Y-m-d'));
        }

        if ($request->request->get('customer') && isset($request->request->get('customer')['id'])) {

            $c = $request->request->get('customer');
            unset($c['id']);

            $request->request->set('customer', $c);
        }
    }
}
