<?php

namespace Rufy\RestApiDevBundle\Controller;

use Rufy\RestApiBundle\Entity\Customer;
use Rufy\RestApiBundle\Entity\Reservation;
use Rufy\RestApiBundle\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FormController extends Controller
{
    public function reservationAction(Request $request)
    {
        $form = $this->createForm('reservation_type', new Reservation(), [
            //'action' => $this->generateUrl('save_reservation'),
            'method' => 'POST'
        ]);

        /**
         * http://symfony.com/it/doc/2.7/book/forms.html#gestione-dell-invio-del-form
         */
        $form->handleRequest($request);

        if ($form->isValid()) {

            $this->getDoctrine()->getManager()->persist($form->getData());
            $this->getDoctrine()->getManager()->flush();

        } else {

            $a = 1;
        }

        $a = 1;

        return $this->render('RufyRestApiDevBundle:Forms:formReservation.html.twig', [

            'form' => $form->createView()
        ]);
    }

    public function customerAction(Request $request)
    {
        $form = $this->createForm('customer_type', new Customer(), [
            //'action' => $this->generateUrl('save_reservation'),
            'method' => 'POST'
        ]);

        /**
         * http://symfony.com/it/doc/2.7/book/forms.html#gestione-dell-invio-del-form
         */
        $form->handleRequest($request);

        if ($form->isValid()) {

            $this->getDoctrine()->getManager()->persist($form->getData());
            $this->getDoctrine()->getManager()->flush();

        } else {

            $a = 1;
        }

        $a = 1;

        return $this->render('RufyRestApiDevBundle:Forms:formCustomer.html.twig', [

            'form' => $form->createView()
        ]);
    }
}
