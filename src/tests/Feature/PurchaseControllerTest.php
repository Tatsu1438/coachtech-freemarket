<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_purchase_product()
    {
        $password = 'password123';
        $user = User::factory()->create([
        'password' => \Hash::make($password),
        'postal_code' => '123-4567',
        'address' => '東京都中央区1-1-1',
        'building' => 'テストビル101',
        ]);
        $product = Product::factory()->create([
            'price' => 1000,
        ]);
        
        $response = $this->actingAs($user)->post(route('purchase.store', $product->id), [
        'payment_method' => 'クレジットカード',
        'postal_code' => $user->postal_code,
        'address' => $user->address,
        'building' => $user->building,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $product->id,
            'payment_method' => 'クレジットカード',
            'price' => $product->price,
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);
    }

    public function test_sold_label_displayed_for_purchased_items()
    {
        $password = 'password123';
        $user = User::factory()->create([
            'password' => \Hash::make($password),
            'postal_code' => '123-4567',
            'address' => '兵庫県神戸市中央区1-1-1',
            'building' => 'テストビル',
        ]);

        $product = Product::factory()->create();

        $purchase = Purchase::create([
            'user_id' => $user->id,
            'item_id' => $product->id,
            'price' => $product->price,
            'payment_method' => 'クレジットカード',
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        $response = $this->actingAs($user)->get(route('items.top'));
        $response->assertStatus(200);
        $response->assertSee('SOLD');
    }

    public function test_purchased_item_appears_in_user_profile()
    {
        $password = 'password123';
        $user = User::factory()->create([
            'password' => \Hash::make($password),
            'postal_code' => '123-4567',
            'address' => '兵庫県神戸市中央区1-1-1',
            'building' => 'テストビル',
        ]);

        $product = Product::factory()->create([
            'product_name' => 'テスト商品',
            'price' => 5000,
            'img_url' => 'storage/test.jpg',
        ]);

        $purchase = Purchase::create([
            'user_id' => $user->id,
            'item_id' => $product->id,
            'price' => $product->price,
            'payment_method' => 'クレジットカード',
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        $response = $this->actingAs($user)->get(route('profile.bought'));
        $response->assertStatus(200);

        $response->assertSee('テスト商品');
    }

    public function test_payment_method_is_saved()
    {
        $this->withoutExceptionHandling();
        $password = 'password123';
        $user = User::factory()->create([
            'password' => \Hash::make($password),
            'postal_code' => '123-4567',
            'address' => '兵庫県神戸市中央区1-1-1',
            'building' => 'テストビル',
        ]);
        $product = Product::factory()->create(['price' => 3000]);

        $response = $this->actingAs($user)->post(route('purchase.store', $product->id), [
            'payment_method' => 'コンビニ払い',
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $product->id,
            'payment_method' => 'コンビニ払い',
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);
    }

    public function test_shipping_address_is_saved_with_purchase()
    {
        $this->withoutExceptionHandling();
        $password = 'password123';
        $user = User::factory()->create([
            'password' => \Hash::make($password),
            'postal_code' => '123-4567',
            'address' => '兵庫県神戸市中央区1-1-1',
            'building' => 'テストビル',
        ]);
        $product = Product::factory()->create(['price' => 3000]);

        $response = $this->actingAs($user)->post(route('purchase.store', $product->id), [
            'payment_method' => 'コンビニ払い',
            'postal_code' => '123-4567',
            'address' => '兵庫県神戸市中央区1-1-1',
            'building' => 'テストビル',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $product->id,
            'payment_method' => 'コンビニ払い',
            'postal_code' => '123-4567',
            'address' => '兵庫県神戸市中央区1-1-1',
            'building' => 'テストビル',
        ]);
    }

    public function test_user_can_see_purchase_history()
    {
        $password = 'password123';
        $user = User::factory()->create([
            'password' => \Hash::make($password),
            'postal_code' => '123-4567',
            'address' => '兵庫県神戸市中央区1-1-1',
            'building' => 'テストビル',
        ]);

        $product1 = Product::factory()->create([
            'product_name' => 'テスト商品A',
            'price' => 5000,
            'img_url' => 'storage/test.jpg',
        ]);

        $product2 = Product::factory()->create([
            'product_name' => 'テスト商品B',
            'price' => 6000,
            'img_url' => 'storage/test.jpg',
        ]);

        \App\Models\Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $product1->id,
            'payment_method' => 'クレジットカード',
            'price' => $product1->price,
        ]);

        \App\Models\Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $product2->id,
            'payment_method' => 'コンビニ払い',
            'price' => $product2->price,
        ]);

        $response = $this->actingAs($user)->get('/mypage_bought');

        $response->assertStatus(200);
        $response->assertSee('テスト商品A');
        $response->assertSee('テスト商品B');
    }

    public function test_payment_method_reflects_in_purchase_page()
    {
        $password = 'password123';
        $user = User::factory()->create([
            'password' => \Hash::make($password),
            'postal_code' => '123-4567',
            'address' => '兵庫県神戸市中央区1-1-1',
            'building' => 'テストビル',
        ]);
        $product = Product::factory()->create(['price' => 5000]);

        $response = $this->actingAs($user)->get(route('items.purchase', $product->id));
        $response->assertStatus(200);

        $response->assertSee('name="payment_method"', false);
        $response->assertSee('コンビニ払い');
        $response->assertSee('クレジットカード払い');
    }

    public function test_shipping_address_links_to_purchased_item()
    {
        $password = 'password123';
        $user = User::factory()->create([
            'password' => \Hash::make($password),
            'postal_code' => '123-4567',
            'address' => '兵庫県神戸市中央区1-1-1',
            'building' => 'テストビル',
        ]);
        $product = Product::factory()->create(['price' => 6000]);

        $response = $this->actingAs($user)->post(route('purchase.store', $product->id), [
            'payment_method' => 'コンビニ払い',
            'postal_code' => '123-4567',
            'address' => '兵庫県神戸市中央区1-1-1',
            'building' => 'テストビル',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $product->id,
        ]);
    }
}