<?php namespace Rufy\RestApiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * TODO
 * Provare a creare un controller come servizio con metodi condivisi
 * Rifattorizzare l'utilizzo dell'handler nei controller??
 * Controllo Servizi / Injection con firma con interfacce
 * Implementazione auth con token piuttosto che basic:
 *  - http://symfony.com/it/doc/current/cookbook/security/api_key_authentication.html
 * Sistemare setTableDimension() e setTablePosition() nel salvataggio della reservation
 * Bloccare cors solo per il client
 *-----------------------------------------------------------------------
 *
 *
 * Class RufyRestApiBundle
 * @package Rufy\RestApiBundle
 */
class RufyRestApiBundle extends Bundle
{
}
