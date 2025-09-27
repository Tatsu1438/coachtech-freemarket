<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory()->create([
            'email' => 'tatsuya@example.com',
            'password' => Hash::make('password123'),
        ]);
    }

    public function test_email_is_required()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_password_is_required()
    {
        $response = $this->post('/login', [
            'email' => 'tatsuya@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_email_must_exist()
    {
        $response = $this->post('/login', [
            'email' => 'notfound@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_password_must_be_correct()
    {
        $response = $this->post('/login', [
            'email' => 'tatsuya@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_successful_login_redirects_dashboard()
    {
        $response = $this->post('/login', [
            'email' => 'tatsuya@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/top_mylist');
        $this->assertAuthenticated();
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect('/');
        
        $this->assertGuest();
    }
}