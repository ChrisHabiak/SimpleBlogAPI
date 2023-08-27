<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class AdminEditorPanelTest extends TestCase
{
    use RefreshDatabase;

    public function testEditorCanListPosts()
    {
        $editor = User::factory()->create(['role_id' => Role::getEditorRoleID()]);
        $posts = Post::factory(5)->create();

        $response = $this->actingAs($editor)->get('/api/posts');

        $response->assertStatus(200)
            ->assertSee($posts[0]->title)
            ->assertSee($posts[4]->title);
    }

    public function testEditorCanAddEditAndDeletePost()
    {
        $editor = User::factory()->create(['role_id' => Role::getEditorRoleID()]);
        $post = Post::factory()->create();

        $response = $this->actingAs($editor)->post('/api/posts', [
            'title' => 'New Post',
            'content' => 'This is a new post content.',
        ]);

        $response->assertStatus(204);

        $this->assertDatabaseHas('posts', ['title' => 'New Post']);

        $response = $this->actingAs($editor)->put("/api/posts/{$post->id}", [
            'title' => 'Updated Post',
            'content' => 'Updated post content.',
        ]);

        $response->assertStatus(204);

        $this->assertDatabaseHas('posts', ['title' => 'Updated Post']);

        $response = $this->actingAs($editor)->delete("/api/posts/{$post->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function testRegularUserCannotAddOrDeletePost()
    {
        $regularUser = User::factory()->create();

        $response = $this->actingAs($regularUser)->post('/api/posts', [
            'title' => 'New Post',
            'content' => 'This is a new post content.',
        ]);

        $response->assertStatus(403);

        $post = Post::factory()->create();
        $response = $this->actingAs($regularUser)->delete("/api/posts/{$post->id}");

        $response->assertStatus(403);
    }

    public function testAdminCanListUsers()
    {
        $admin = User::factory()->create(['role_id' => Role::getAdminRoleID()]);
        $users = User::factory(5)->create();

        $response = $this->actingAs($admin)->get('/api/users');

        $response->assertStatus(200);
    }


    public function testEditorCannotListUsers()
    {
        $editor = User::factory()->create(['role_id' => Role::getEditorRoleID()]);
        $users = User::factory(5)->create();

        $response = $this->actingAs($editor)->get('/api/users');

        $response->assertStatus(403); // Ensure Forbidden response for editor
    }


    public function testAdminCanAddEditDeleteAndChangeUserRole()
    {
        $admin = User::factory()->create(['role_id' => Role::getAdminRoleID()]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->post('/api/users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'role_id' => Role::getEditorRoleID()
        ]);

        $response->assertStatus(204);

        $this->assertDatabaseHas('users', ['name' => 'New User', 'role_id' => Role::getEditorRoleID()]);

        $response = $this->actingAs($admin)->put("/api/users/{$user->id}", [
            'name' => 'Updated User',
            'email' => 'updateduser@example.com',
            'role_id' => Role::getAdminRoleID()
        ]);

        $response->assertStatus(204);

        $this->assertDatabaseHas('users', ['name' => 'Updated User', 'role_id' => Role::getAdminRoleID()]);

        $response = $this->actingAs($admin)->delete("/api/users/{$user->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
