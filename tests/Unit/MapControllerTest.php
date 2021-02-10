<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Tests\TestCase;
use App\Http\Controllers\MapController;

class MapControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_index_GetStatus()
    {
        $controller = new MapController();
        $response = $controller->index();
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_index_GetContent()
    {
        $fakeContent = '[{"id":1,"name":"Africa","zoom":2.5,"latitude_center":2,"longitude_center":15,"handicap":2000,"rounds":5,"created_at":null,"updated_at":null},{"id":2,"name":"USA","zoom":3.2,"latitude_center":40,"longitude_center":-96,"handicap":2000,"rounds":5,"created_at":null,"updated_at":null},{"id":3,"name":"South America","zoom":2.4699999999999998,"latitude_center":-25,"longitude_center":-58,"handicap":1500,"rounds":5,"created_at":null,"updated_at":null},{"id":4,"name":"Australia","zoom":3.6,"latitude_center":-29,"longitude_center":134,"handicap":2000,"rounds":5,"created_at":null,"updated_at":null},{"id":5,"name":"Europe","zoom":2.75,"latitude_center":57,"longitude_center":15,"handicap":1000,"rounds":5,"created_at":null,"updated_at":null},{"id":6,"name":"Asia","zoom":2.2,"latitude_center":45,"longitude_center":86,"handicap":1000,"rounds":5,"created_at":null,"updated_at":null},{"id":7,"name":"Hungary","zoom":6.3,"latitude_center":47,"longitude_center":19.5,"handicap":150,"rounds":5,"created_at":null,"updated_at":null}]';
        $controller = new MapController();
        $response = $controller->index();
        $mapContent = $response->getContent();
        $this->assertEquals($fakeContent, $mapContent);
    }

    public function test_show_getStatus404()
    {
        $request1 = new Request();
        $request2 = new Request();
        $request1->request->add(['id' => 0]);
        $request2->request->add(['id' => 8]);
        $controller = new MapController();
        $response1 = $controller->show($request1);
        $response2 = $controller->show($request2);
        $this->assertEquals(404, $response1->getStatusCode());
        $this->assertEquals(404, $response2->getStatusCode());

    }

    public function test_show_getStatus200()
    {
        $request = new Request();
        $request->request->add(['id' => 1]);
        $controller = new MapController();
        $response = $controller->show($request);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
