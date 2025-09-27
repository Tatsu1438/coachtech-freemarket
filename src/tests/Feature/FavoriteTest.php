<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_favorite_a_product()
    {
        $password = 'password123';
        $user = User::factory()->create(['password' => \Hash::make($password)]);
        $product = Product::factory()->create();

        $response = $this->post('/login', [ 'email' => $user->email, 'password' => $password,
        ]);

        $response->assertRedirect('/top_mylist');

        $response = $this->actingAs($user)->post("/favorites/{$product->id}");

        $response->assertStatus(302);
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

    }

    /** @test */
    public function favorite_icon_changes_color_when_favorited()
    {
        $password = 'password123';
        $user = User::factory()->create(['password' => \Hash::make($password)]);
        $product = Product::factory()->create();

        $response = $this->post("/favorites/{$product->id}");
        $response->assertStatus(302);

        $response = $this->actingAs($user)->get("/item/{$product->id}");
    }

    /** @test */
    public function authenticated_user_can_unfavorite_a_product()
    {
        $password = 'password123';
        $user = User::factory()->create(['password' => \Hash::make($password)]);
        $product = Product::factory()->create();
        $user->favorites()->attach($product->id);
        $response = $this->post("/favorites/{$product->id}");
        $response->assertStatus(302);

        $user->favorites()->detach($product->id);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
        $response->assertStatus(302);
    }

    /** @test */
    public function guest_cannot_favorite_a_product()
    {
        $product = Product::factory()->create();

        $response = $this->post("/favorites/{$product->id}");

        $response->assertRedirect('/login');
        $this->assertDatabaseCount('favorites', 0);
    }

    /** @test */
    public function favoriting_a_product_increases_total_count()
    {
        $password = 'password123';
        $user = User::factory()->create(['password' => \Hash::make($password)]);
        $product = Product::factory()->create();

        $initialCount = $product->favorites()->count();


        $user->favorites()->attach($product->id);
        $response = $this->post("/favorites/{$product->id}");


        $newCount = $product->favorites()->count();


        $response = $this->assertEquals($initialCount + 1, $newCount);
    }
}