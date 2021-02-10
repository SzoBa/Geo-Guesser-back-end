<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginControllerTest extends TestCase
{

    public function testMissingPasswordForLogin(): void
    {

        $response = $this->json('post', 'api/login', [
            'email' => 'test@test.com',
        ]);
        self::assertEquals('{"password":["The password field is required."]}', $response->getContent());
    }

    public function testingInvalidLoginEmailInformationForLogin(): void
    {

        $response = $this->json('post', 'api/login', [
            'email' => 'testfail@test.com',
            'password' => 'something_fake'
        ]);
        self::assertEquals('{"email":["The selected email is invalid."]}', $response->getContent());
    }

    public function testingInvalidLoginPasswordInformationForLogin(): void
    {

        $response = $this->json('post', 'api/login', [
            'email' => 'test@test.com',
            'password' => 'something_fake'
        ]);
        self::assertEquals('{"message":["Wrong password!"]}', $response->getContent());
    }

    public function testSuccessfulLogin(): void
    {

        $response = $this->json('post', 'api/login', [
            'email' => 'test@test.com',
            'password' => '12345678'
        ]);
        $response->assertStatus(201);
    }

    /*
     * This is not working - Postman test
    public function testSuccessfulLogout(): void
    {
        $loginResponse = $this->json('post', 'api/login', [
            'email' => 'test@test.com',
            'password' => '12345678'
        ]);

        $token = $loginResponse->getOriginalContent()['token'];
        $headerValue = 'Bearer ' . $token;
        $response = $this
            ->withHeader('Authorization', $headerValue)
            ->json('delete', 'api/logout');
        $response->assertStatus(204);
    }
    */
}
