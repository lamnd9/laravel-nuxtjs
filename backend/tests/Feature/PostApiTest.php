<?php
use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_post_successfully()
    {
        $data = [
            'title' => 'Valid Title',
            'content' => 'Valid content',
            'views' => 10,
            'start_at' => now()->format('Y-m-d H:i:s'),
            'end_at' => now()->addDay()->format('Y-m-d H:i:s'),
        ];

        $response = $this->postJson('/api/posts', $data);

        $response->assertStatus(201)
                ->assertJsonFragment(['title' => 'Valid Title']);
    }

    public function test_cannot_create_post_with_invalid_data()
    {
        $response = $this->postJson('/api/posts', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title', 'content']);
    }

    public function test_create_post_fails_without_title()
    {
        $data = [
            'title' => '',
            'content' => 'Some content',
            'views' => 5,
        ];

        $response = $this->postJson('/api/posts', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['title']);
    }

    public function test_create_post_fails_with_invalid_views()
    {
        $data = [
            'title' => 'Test',
            'content' => 'Test',
            'views' => 'abc', // invalid
        ];

        $response = $this->postJson('/api/posts', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['views']);
    }

    public function test_create_post_fails_when_end_at_is_before_start_at()
    {
        $data = [
            'title' => 'Time Test',
            'content' => 'Testing time logic',
            'views' => 1,
            'start_at' => now()->addDay()->format('Y-m-d H:i:s'),
            'end_at' => now()->format('Y-m-d H:i:s'), // nhỏ hơn start_at
        ];

        $response = $this->postJson('/api/posts', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['end_at']);
    }

    public function test_can_get_post_list()
    {
        Post::factory()->count(3)->create();

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }
}
