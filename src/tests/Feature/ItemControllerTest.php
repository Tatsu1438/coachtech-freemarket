<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_top_view()
    {
        $products = Product::factory()->count(12)->create();
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('items.top');

        foreach ($products as $product) {
        $response->assertSee($product->name);
        }

        $this->assertCount(12, $products);
    }

    public function test_mylist_requires_authentication()
    {
        $response = $this->get('/top_mylist');
        $response->assertRedirect('/login');
    }

    public function test_mylist_displays_favorites_for_authenticated_user()
    {
        $password = 'password123';
        $user = User::factory()->create(['password' => \Hash::make($password)]);
        $favoriteProduct = Product::factory()->create();
        $otherProduct = Product::factory()->create();

        $user->favorites()->attach($favoriteProduct->id);

        $response = $this->actingAs($user)->get('/top_mylist');
        $response->assertStatus(200);
        $response->assertViewIs('items.top_mylist');

        $response->assertSee($favoriteProduct->item_name);
        $response->assertDontSee($otherProduct->item_name);
    }

    public function test_search_returns_items_by_name()
    {
        $product1 = Product::factory()->create(['product_name' => 'タンブラー']);
        $product2 = Product::factory()->create(['product_name' => '腕時計']);

        $response = $this->get('/items/search?keyword=腕時計');

        $response->assertStatus(200);
        $response->assertViewIs('items.top');
        $response->assertSee('腕時計');
        $response->assertDontSee('タンブラー');
    }

    public function test_search_returns_items_by_category()
    {
        $category = Category::factory()->create(['category' => 'メンズ']);
        $product = Product::factory()->create(['product_name' => '腕時計']);
        $product->categories()->attach($category->id);

        $response = $this->get('/items/search?keyword=メンズ');

        $response->assertStatus(200);
        $response->assertViewIs('items.top');
        $response->assertSee($product->product_name);
    }

    public function test_search_partial_match_and_keyword_preserved()
    {
        $product1 = Product::factory()->create(['product_name' => '腕時計A']);
        $product2 = Product::factory()->create(['product_name' => '腕時計B']);
        $product3 = Product::factory()->create(['product_name' => 'タンブラー']);

        $keyword = '腕';

        $response = $this->get('/items/search?keyword=' . $keyword);

        $response->assertStatus(200);
        $response->assertViewIs('items.top');
        $response->assertSee('腕時計A');
        $response->assertSee('腕時計B');
        $response->assertDontSee('タンブラー');
        $response->assertSee('value="' . $keyword . '"', false);
    }

    public function test_show_displays_item_detail_view()
    {
        $item = Product::factory()->create();
        $response = $this->get("/item/{$item->id}");
        $response->assertStatus(200);
        $response->assertViewIs('items.item_detail');
    }

    public function test_show_displays_item_detail_view_with_all_details()
    {
        $password = 'password123';
        $user = User::factory()->create(['password' => \Hash::make($password)]);

        $item = Product::factory()->create([
            'product_name' => 'テスト商品',
            'brand'        => 'ブランドA',
            'description'  => 'これはテスト商品の説明です。',
            'price'        => 5000,
            'condition'    => '新品',
        ]);

        $comment1 = Comment::factory()->create([
            'product_id' => $item->id,
            'user_id'    => $user->id,
            'comment'    => 'いい商品ですね！',
        ]);
        $comment2 = Comment::factory()->create([
            'product_id' => $item->id,
            'user_id'    => $user->id,
            'comment'    => 'デザインが好きです。',
        ]);

        $users = User::factory()->count(3)->create();
        foreach ($users as $u) {
            $u->favorites()->attach($item->id);
        }

        $response = $this->get("/item/{$item->id}");
        $response->assertStatus(200);
        $response->assertViewIs('items.item_detail');
        $response->assertSee('テスト商品');
        $response->assertSee('ブランドA');
        $response->assertSee('新品');
        $response->assertSee('これはテスト商品の説明です。');
        $response->assertSee('いい商品ですね！');
        $response->assertSee('デザインが好きです。');
        $this->assertEquals(2, $item->comments()->count());
        $this->assertEquals(3, $item->favorites()->count());
        $response->assertSee($item->img);
    }

    public function test_show_displays_item_detail_with_categories()
    {
        $password = 'password123';
        $user = User::factory()->create(['password' => \Hash::make($password)]);


        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        $item = \App\Models\Product::factory()->create([
            'product_name' => 'テスト商品',
            'brand'        => 'ブランドA',
            'description'  => 'これはテスト商品の説明です。',
            'price'        => 5000,
            'condition'    => '新品',
            'user_id'      => $user->id,
        ]);
        $item->categories()->attach([$category1->id, $category2->id]);
        $response = $this->get("/item/{$item->id}");
        $response->assertStatus(200);
        $response->assertViewIs('items.item_detail');

        $response->assertSee($category1->category);
        $response->assertSee($category2->category);

    }

    public function test_sell_displays_sell_view()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/sell');
        $response->assertStatus(200);
        $response->assertViewIs('items.sell');
    }


    public function test_purchase_displays_purchase_page_for_authenticated_user()
    {
        $password = 'password123';
        $user = User::factory()->create(['password' => \Hash::make($password)]);
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->get("/purchase/{$product->id}");
        $response->assertStatus(200);
        $response->assertViewIs('items.purchase');
        $response->assertViewHasAll(['item', 'user']);
        $response->assertSee($product->name);
    }

    public function test_purchase_redirects_non_authenticated_user()
    {
        $product = Product::factory()->create();

        $response = $this->get("/purchase/{$product->id}");
        $response->assertRedirect('/login');
    }


    public function test_store_creates_product_and_redirects()
    {
        Storage::fake('public');

        $password = 'password123';
        $user = User::factory()->create(['password' => \Hash::make($password)]);

        $file = UploadedFile::fake()->create('test.jpg', 100);

        $category = Category::factory()->create(['category' => 'カテゴリA']);

        $productData = [
            'product_name' => 'テスト商品',
            'brand'        => 'ブランドA',
            'description'  => 'テスト説明',
            'price'        => 5000,
            'condition'    => '新品',
            'user_id'      => $user->id,
            'category' => [$category->category],
            'img_url'      => $file,
        ];

        $response = $this->actingAs($user)->post(route('items.store'), $productData);
        $response->assertRedirect(route('items.top'));
        $response->assertSessionHas('success', '商品を出品しました！');

        $this->assertDatabaseHas('products', [
            'product_name' => 'テスト商品',
            'brand'        => 'ブランドA',
            'description'  => 'テスト説明',
            'price'        => 5000,
            'condition'    => '新品',
            'img_url'      => 'images/' . $file->hashName(),
            'user_id'      => $user->id,
        ]);

        Storage::disk('public')->assertExists('images/' . $file->hashName());

    }

    public function test_store_validation_errors_redirect_back()
    {
        Storage::fake('public');

        $password = 'password123';
        $user = User::factory()->create(['password' => \Hash::make($password)]);

        $file = UploadedFile::fake()->create('test.jpg', 100);

        $category = Category::factory()->create(['category' => 'カテゴリA']);

        $productData = [
            'brand'        => 'ブランドA',
            'description'  => 'テスト説明',
            'price'        => 5000,
            'user_id'      => $user->id,
            'category' => [$category->category],
            'img_url'      => $file,
        ];

        $response = $this->actingAs($user)->post(route('items.store'), $productData);

        $response->assertSessionHasErrors(['product_name','condition']);
    }

    public function test_sell_requires_authentication()
    {
        $response = $this->get('/sell');
        $response->assertRedirect('/login');
    }

    public function test_store_with_multiple_categories()
    {
        $this->refreshDatabase();

        Storage::fake('public');

        $password = 'password123';
        $user = User::factory()->create(['password' => \Hash::make($password)]);
        $categories = Category::factory()->count(2)->create();
        $file = UploadedFile::fake()->create('test.jpg', 100);

        $data = [
            'product_name' => 'マルチカテゴリ商品',
            'brand'        => 'ブランドB',
            'description'  => 'テスト説明',
            'price'        => 10000,
            'category'     => $categories->pluck('category')->toArray(),
            'condition'    => '中古',
            'img_url'          => $file,
        ];

        $response = $this->actingAs($user)->post(route('items.store'), $data);

        $response->assertRedirect(route('items.top'));
        $this->assertDatabaseHas('products', ['product_name' => 'マルチカテゴリ商品']);
        foreach ($categories as $category) {
            $this->assertDatabaseHas('category_product', [
                'product_id' => Product::where('product_name', 'マルチカテゴリ商品')->first()->id,
                'category_id' => $category->id,
            ]);
        }

        Storage::disk('public')->assertExists('images/' . $file->hashName());
    }
}