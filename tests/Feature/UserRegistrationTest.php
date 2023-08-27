<?php

namespace Tests\Feature;

use App\Events\UserRegisteredEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testUserRegistrationWithValidData()
    {
        Event::fake();

        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'name', 'email', 'role_id']]);

        Event::assertDispatched(UserRegisteredEvent::class);

    }

    public function testUserRegistrationWithInvalidName()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'A', // Name is too short
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function testUserRegistrationWithInvalidEmail()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'invalid-email', // Invalid email format
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function testUserRegistrationWithInvalidPassword()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'short', // Password is too short
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function testUserRegistrationWithDefaultRole()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJson(['data' => ['role_id' => null]]);
    }
}
