<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_send_comment()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post("/item/{$product->id}/comment", [
            'comment' => 'テストコメントです',
        ]);

        $response->assertRedirect(); // コメント後リダイレクトされる想定
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'comment' => 'テストコメントです',
        ]);
    }

    /** @test */
    public function guest_cannot_send_comment()
    {
        $product = Product::factory()->create();

        $response = $this->post("/item/{$product->id}/comment", [
            'comment' => 'テストコメントです',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseCount('comments', 0);
    }

    /** @test */
    public function comment_cannot_be_empty()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post("/item/{$product->id}/comment", [
            'comment' => '',
        ]);

        $response->assertSessionHasErrors('comment');
    }

    /** @test */
    public function comment_cannot_exceed_255_characters()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $longComment = str_repeat('あ', 256);

        $response = $this->actingAs($user)->post("/item/{$product->id}/comment", [
            'comment' => $longComment,
        ]);

        $response->assertSessionHasErrors('comment');
    }

    /** @test */
    public function comment_count_increases_when_new_comment_is_added()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        // コメント追加前の count を確認
        $this->assertEquals(0, $product->comments()->count());

        // コメントを1件追加
        $this->actingAs($user)->post("/item/{$product->id}/comment", [
            'comment' => '1件目のコメント',
        ]);

        // 再取得してカウントが増えてるか確認
        $this->assertEquals(1, $product->fresh()->comments()->count());

        // さらにコメントを追加
        $this->actingAs($user)->post("/item/{$product->id}/comment", [
            'comment' => '2件目のコメント',
        ]);

        // 合計値が 2 件になっているか
        $this->assertEquals(2, $product->fresh()->comments()->count());
    }
}