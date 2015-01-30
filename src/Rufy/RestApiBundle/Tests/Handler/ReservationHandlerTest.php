<?php namespace Rufy\RestApiBundle\Tests\Handler;

use Rufy\RestApiBundle\Handler\ReservationHandler;
use Rufy\RestApiBundle\Model\ReservationInterface;
use Rufy\RestApiBundle\Entity\Reservation;
use Guzzle\Service\Client;

class ReservationHandlerTest extends \PHPUnit_Framework_TestCase
{
    const RESERVATION_CLASS = 'Rufy\RestApiBundle\Tests\Handler\DummyReservation';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $_client;

    public function setUp()
    {
        $this->_client = new Client('http://rufysf.local');
    }

    public function testGetJson()
    {
        $resourceId = 1;

        $request        = $this->_client->get('app_dev.php/api/v1/reservations/'.$resourceId);
        $response       = $request->send();

        $this->assertEquals(200, $response->getStatusCode());

        $jsonResponse   = $response->json();

        $this->assertJson(json_encode($jsonResponse));

        $this->assertArrayHasKey('id', $jsonResponse);
        $this->assertArrayHasKey('name', $jsonResponse);
        $this->assertArrayHasKey('phone', $jsonResponse);
        $this->assertArrayHasKey('area', $jsonResponse);
        $this->assertArrayHasKey('tableName', $jsonResponse);
        $this->assertArrayHasKey('turn', $jsonResponse);
        $this->assertArrayHasKey('people', $jsonResponse);
        $this->assertArrayHasKey('date', $jsonResponse);
        $this->assertArrayHasKey('time', $jsonResponse);
        $this->assertArrayHasKey('confirmed', $jsonResponse);
        $this->assertArrayHasKey('waiting', $jsonResponse);
        $this->assertArrayHasKey('drawingWidth', $jsonResponse);
        $this->assertArrayHasKey('drawingHeight', $jsonResponse);
        $this->assertArrayHasKey('drawingPosX', $jsonResponse);
        $this->assertArrayHasKey('drawingPosY', $jsonResponse);
    }
}
