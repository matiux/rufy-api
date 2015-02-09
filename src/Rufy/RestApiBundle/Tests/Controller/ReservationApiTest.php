<?php namespace Rufy\RestApiBundle\Tests\Controller;

use Guzzle\Service\Client;

class ReservationHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Guzzle\Service\Client
     */
    protected $_client;

    public function setUp()
    {
        $this->_client = new Client('http://rufysf.local');
    }

    public function testGetJson()
    {
        $resourceId     = 1;
        $request        = $this->_client->get('app_dev.php/api/v1/reservations/'.$resourceId, [], ['auth' => ['matiux', '281285']]);
        $response       = $request->send();

        $this->assertEquals(200, $response->getStatusCode());

        $jsonResponse   = $response->json();

        $this->analyzeBasic($jsonResponse);

        $this->analyzeReservation($jsonResponse['data']);
    }

    public function testGetCollectionJson()
    {
        $resourceId     = 1;
        $request        = $this->_client->get('app_dev.php/api/v1/restaurants/'.$resourceId.'/reservations', [], ['auth' => ['matiux', '281285']]);
        $response       = $request->send();

        $this->assertEquals(200, $response->getStatusCode());

        $jsonResponse   = $response->json();

        $this->analyzeBasic($jsonResponse);

        // C'è almeno una Reservation nella collezione
        $this->assertTrue(0 < count($jsonResponse));

        // Ne analizzo una
        $this->analyzeReservation(current($jsonResponse['data']));
    }

    private function analyzeBasic($jsonResponse)
    {
        // E' un json
        $this->assertJson(json_encode($jsonResponse));

        //C'è la chiave data
        $this->assertArrayHasKey('data', $jsonResponse);
    }

    private function analyzeReservation($reservation)
    {
        $this->assertArrayHasKey('name', $reservation);
        $this->assertArrayHasKey('phone', $reservation);
        $this->assertArrayHasKey('area', $reservation);
        $this->assertArrayHasKey('areaId', $reservation);
        $this->assertArrayHasKey('tableName', $reservation);
        $this->assertArrayHasKey('people', $reservation);
        $this->assertArrayHasKey('date', $reservation);
        $this->assertArrayHasKey('note', $reservation);
        $this->assertArrayHasKey('time', $reservation);
        $this->assertArrayHasKey('confirmed', $reservation);
        $this->assertArrayHasKey('waiting', $reservation);
        $this->assertArrayHasKey('drawingWidth', $reservation);
        $this->assertArrayHasKey('drawingHeight', $reservation);
        $this->assertArrayHasKey('drawingPosX', $reservation);
        $this->assertArrayHasKey('drawingPosY', $reservation);
        $this->assertArrayHasKey('reservationOptions', $reservation);
    }
}
