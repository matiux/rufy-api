<?php namespace Rufy\RestApiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * TODO
 * Provare a creare un controller come servizio con metodi condivisi
 * Rifattorizzare l'utilizzo dell'handler nei controller??
 * Voter per associazione opzioni_area alle aree in fase di salvataggio prenotazione (AreaRepository::hasOptions()) - Finire
 * Il posto dovrebbe restituire 201
 * Allineare Test
 *      - PhpSpec per unitari
 *      - Behat per funzionali - aggiungere casi con errori 403 - 404 - 400 ecc
 *-----------------------------------------------------------------------
 *
 *
 * Class RufyRestApiBundle
 * @package Rufy\RestApiBundle
 */
class RufyRestApiBundle extends Bundle
{
}
