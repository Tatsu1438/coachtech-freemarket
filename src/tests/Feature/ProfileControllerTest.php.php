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

    public function test_edit_view_displays_current_user_information()
    {
        $user = User::factory()->create([
            'name' => '初期ユーザー',
            'email' => 'initial@example.com',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertViewIs('profile.mypage_edit');

        // Bladeに渡されている user が正しいか
        $response->assertViewHas('user', function ($viewUser) use ($user) {
            return $viewUser->id === $user->id &&
                $viewUser->name === '初期ユーザー' &&
                $viewUser->email === 'initial@example.com';
        });

        // 実際に画面上に初期値が埋め込まれてるか確認
        $response->assertSee('初期ユーザー');
        $response->assertSee('initial@example.com');
    }

    public function test_update_user_information()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/mypage/profile', [
            'name' => '更新後の名前',
            'email' => 'updated@example.com',
        ]);

        // リダイレクトされるか確認
        $response->assertRedirect('/mypage/profile');

        // DBの値が更新されているか確認
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '更新後の名前',
            'email' => 'updated@example.com',
        ]);
    }
}