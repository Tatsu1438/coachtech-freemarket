<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_required()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_email_is_required()
    {
        $response = $this->post('/register', [
            'name' => 'Tatsuya',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_password_is_required()
    {
        $response = $this->post('/register', [
            'name' => 'Tatsuya',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_password_min_length()
    {
        $response = $this->post('/register', [
            'name' => 'Tatsuya',
            'email' => 'test@example.com',
            'password' => 'pass8',
            'password_confirmation' => 'pass8',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_password_confirmation_must_match()
    {
        $response = $this->post('/register', [
            'name' => 'Tatsuya',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password456',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_register_redirects_to_verification_notice_and_user_is_unverified()
    {
        $response = $this->post('/register', [
            'name' => 'Tatsuya',
            'email' => 'tatsuya@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('verification.notice'));


        $this->assertDatabaseHas('users', [
            'email' => 'tatsuya@example.com',
            'email_verified_at' => null,
        ]);
    }

    public function test_it_can_resend_verification_email()
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->post(route('verification.send'));

        $response->assertStatus(302);
        $response->assertSessionHas('message', '認証メールを再送しました');

        Notification::assertSentTo($user, VerifyEmail::class);
    }


    public function test_signed_verification_link_verifies_user_and_redirects_to_mypage_first()
    {
        $user = User::factory()->create([
            'email' => 'tatsuya@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);
        $response->assertRedirect(route('mypage_first'));

        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}