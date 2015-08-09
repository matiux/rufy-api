<?php

namespace Rufy\RestApiDevBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Rufy\RestApiBundle\Entity\Customer;
use Rufy\RestApiBundle\Entity\Reservation;
use Rufy\RestApiBundle\Entity\Restaurant;
use Rufy\RestApiBundle\Form\CustomerType;
use Rufy\RestApiBundle\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FormController extends Controller
{
    public function reservationAction(Request $request)
    {
        $form = $this->createForm(new ReservationType($this->get('security.token_storage'), $this->get('doctrine.orm.entity_manager')), new Reservation(), [
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

        return $this->render('RufyRestApiDevBundle:Forms:formReservation.html.twig', [

            'form' => $form->createView()
        ]);
    }

    public function customerAction(Request $request)
    {
        $form = $this->createForm(new CustomerType($this->get('security.token_storage'), $this->get('doctrine.orm.entity_manager')), new Customer(), [
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * * @View()
     */
    public function restaurantAction(Request $request)
    {
        $form = $this->createForm('restaurant_type', new Restaurant(), [
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

        return $this->render('RufyRestApiDevBundle:Forms:formRestaurant.html.twig', [

            'form' => $form->createView()
        ]);
    }
}
