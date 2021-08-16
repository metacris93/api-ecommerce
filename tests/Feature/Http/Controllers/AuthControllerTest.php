<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    public function test_register()
    {
        $name = $this->faker->name();
        $email = $this->faker->email();
        $data = [
            'name'     => $name,
            'email'    => $email,
            'password' => '12345678',
            'device'   => 'Mobile Device',
        ];
        $response = $this->postJson('api/v1/register', $data);
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('users', [
            'name'  => $name,
            'email' => $email,
        ]);
    }
}
