<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginControllerTest extends TestCase
{

    public function test_missing_password_for_login(): void
    {

        $response = $this->json('post', 'api/login', [
            'email' => 'test@test.com',
        ]);
        self::assertEquals('{"password":["The password field is required."]}', $response->getContent());
    }

    public function test_invalid_login_email_information_for_login(): void
    {

        $response = $this->json('post', 'api/login', [
            'email' => 'testfail@test.com',
            'password' => 'something_fake'
        ]);
        self::assertEquals('{"email":["The selected email is invalid."]}', $response->getContent());
    }

    public function test_invalid_login_password_information_for_login(): void
    {

        $response = $this->json('post', 'api/login', [
            'email' => 'test@test.com',
            'password' => 'something_fake'
        ]);
        self::assertEquals('{"message":["Wrong password!"]}', $response->getContent());
    }

    public function test_successful_login(): void
    {

        $response = $this->json('post', 'api/login', [
            'email' => 'test@test.com',
            'password' => '12345678'
        ]);
        $response->assertStatus(201);
    }

    /*
     * This is not working - Postman test
    public function test_successful_logout(): void
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
