<?php

namespace Tests\Unit;

use App\Http\Controllers\LoginController;

use Illuminate\Http\Request;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testInvalidLoginDataNoUserNoEmail(): void
    {
        $loginController = new LoginController();
        $request = new Request();
        //$request->request->add() or $request->merge()
        $response = $loginController->login($request);
        self::assertEquals('{"email":["The email field is required."],"password":["The password field is required."]}',
            $response->getContent());
    }

}
