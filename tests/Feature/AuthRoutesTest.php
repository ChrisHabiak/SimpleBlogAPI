<?php

namespace Tests\Feature;

use App\Jobs\SendUserResetPasswordLinkMailJob;
use App\Models\PasswordReset;
use App\Models\Role;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class AuthRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function testRegularUserCannotLoginToDashboard()
    {
        $user = User::factory()->create([
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
        ->assertJson([
            'message' => 'You do not have permission to the admin panel',
        ]);
    }

    public function testUserLogin()
    {
        $user = User::factory()->create([
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123'),
            'role_id' => Role::getEditorRoleID()
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);

    }

    public function testSendResetPasswordLink()
    {
        Queue::fake();

        $user =  User::factory()->create([
            'email' => 'johndoe@example.com',
        ]);

        $response = $this->postJson('/api/auth/send-reset-password-link', [
            'email' => 'johndoe@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        Queue::assertPushed(SendUserResetPasswordLinkMailJob::class); // Replace with your actual job class
    }

    public function testResetPassword()
    {
        $user = User::factory()->create([
            'email' => 'johndoe@example.com',
        ]);

        $passwordReset = PasswordReset::factory()->create([
            'email' => 'johndoe@example.com',
        ]);

        $response = $this->postJson('/api/auth/reset-password', [
            'token' => $passwordReset->token,
            'email' => 'johndoe@example.com',
            'password' => 'newpassword123',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

    }

    public function testUserLogout()
    {
        $user = User::factory()->create();

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->postJson('/api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(204);

    }
}
