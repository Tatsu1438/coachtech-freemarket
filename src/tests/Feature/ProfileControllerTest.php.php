<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_sellList_displays_mypage_sold_view()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/mypage_sold');

        $response->assertStatus(200);
        $response->assertViewIs('profile.mypage_sold');
    }

    public function test_buyList_displays_mypage_bought_view()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/mypage_bought');

        $response->assertStatus(200);
        $response->assertViewIs('profile.mypage_bought');
    }

    public function test_edit_displays_mypage_edit_view()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertViewIs('profile.mypage_edit');
    }
}