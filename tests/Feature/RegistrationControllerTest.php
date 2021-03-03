<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{

    public function test_registration_fail_with_mismatching_passwords(): void
    {
        $response = $this->post('/api/registration',
            ['name' => 'test elek',
                'email' => 'test1234@test.com',
                'password' => '12345678',
                'confirm_password' => 'It is a fail confirm']);
        self::assertEquals('{"confirm_password":["The confirm password and password must match."]}',
            $response->getContent());
    }

    public function test_registration_successful(): void
    {
        $response = $this->post('/api/registration',
            ['name' => 'test elek',
                'email' => 'test123@test.com',
                'password' => '12345678',
                'confirm_password' => '12345678']);
        $response->assertStatus(201);
    }

    public function test_registration_fail_with_existing_email(): void
    {
        $this->registerFake();
        $response = $this->post('/api/registration',
            ['name' => 'test elek',
                'email' => 'test123@test.com',
                'password' => '12345678',
                'confirm_password' => '12345678']);
        self::assertEquals('{"email":["The email has already been taken."]}',
            $response->getContent());
    }

    public function tearDown(): void
    {
        $remove = User::query()->where('name', '=', 'test elek')->get();
        if (0 < count($remove)) {
            $remove[0]->delete();
        }
    }

    private function registerFake(): void
    {
        $this->post('/api/registration',
            ['name' => 'test elek',
                'email' => 'test123@test.com',
                'password' => '12345678',
                'confirm_password' => '12345678']);
    }
}
