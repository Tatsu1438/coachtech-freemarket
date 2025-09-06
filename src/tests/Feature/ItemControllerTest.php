<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_top_view()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('items.top');
    }

    public function test_mylist_requires_authentication()
    {
        $response = $this->get('/top_mylist');
        $response->assertRedirect('/login');
    }

    public function test_sell_displays_sell_view()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/sell');
        $response->assertStatus(200);
        $response->assertViewIs('items.sell');
    }

    public function test_show_displays_item_detail_view()
    {
        $itemId = 1; // 仮のID
        $response = $this->get("/item/{$itemId}");
        $response->assertStatus(200);
        $response->assertViewIs('items.item-detail');
    }
}