<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use App\Topic;
use App\Comment;


class CommentTest extends TestCase
{

    use RefreshDatabase;

    public $g_user; // Global user
    public $g_topic; // Global topic
    public $g_comment; // Global comment

    /**
     * Undocumented function
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();
        $this->g_user = $this->createUser(); //  Create the user for testing
        $this->g_topic = $this->createTopic(); //  Create the topic for testing
        $this->g_comment = $this->createComment(); //  Create the comment for testing
    }


    /**
     * Test create comment
     *
     * @return void
     */
    public function testCreateComment()
    {
        $response = $this->actingAs($this->g_user, 'api')
            ->post('api/v1/comment/'. $this->createTopic()->id, $this->commentValid());
        $response->assertStatus(201)
            ->assertJson(
                [
                    'success' => true,
                ]
            )
            ->assertJsonStructure(
                [
                    'status',
                    'success', 
                    'message', 
                    'data',
                ]
            );
    }

    /**
     * Test view comment
     *
     * @return void
     */
    public function testViewComment()
    {
        $response = $this->actingAs($this->g_user, 'api')
            ->get('api/v1/comment/'. $this->g_comment->id);
        $response->assertStatus(200)
            ->assertJson(
                [
                    'success' => true,
                ]
            )
            ->assertJsonStructure(
                [
                    'status',
                    'success', 
                    'message', 
                    'data',
                ]
            );
    }

    /**
     * Test view all topic comments
     *
     * @return void
     */
    public function testVeiwAllTopicComments()
    {
        $response = $this->actingAs($this->g_user, 'api')
            ->get('api/v1/comments/topic/'. $this->g_topic->id);
        $response->assertStatus(200)
            ->assertJson(
                [
                    'success' => true,
                ]
            )
            ->assertJsonStructure(
                [
                    'status',
                    'success', 
                    'message', 
                    'per_page',
                    'item_count', 
                    'total_count',
                    'data',
                    'prev_page',
                    'next_page',
                ]
            );
    }

    /**
     * Test delete comment
     *
     * @return void
     */
    public function testDeleteTopic()
    {
        $response = $this->actingAs($this->g_user, 'api')
            ->delete('api/v1/comment/'. $this->g_comment->id);
        $response->assertStatus(200)
            ->assertJson(
                [
                    'success' => true,
                    'message' => 'Comment deleted successfully',
                ]
            )
            ->assertJsonStructure(
                [
                    'status',
                    'success', 
                    'message', 
                    'data',
                ]
            );
    }

    /**
     * Create user
     *
     * @return object
     */
    public function createUser()
    {
        return User::create([
            'email'    => 'test@email.com',
            'password' => bcrypt('Password123_'),
            'firstname' => 'John',
            'lastname' => 'Doe',
            'phone_number' => '0899554433',
        ]);
    }

    /**
     * Create topic
     *
     * @return object
     */
    public function createTopic()
    {
        return Topic::create(
            [
                'title' => 'Some title',
                'hashtag' => '#'. str_replace(' ', '', ucwords('Some title')),
                'description' => 'Some description',
                'user_id' => $this->g_user->id
            ]
        );
    }

    /**
     * Create comment
     *
     * @return object
     */
    public function createComment()
    {
        return Comment::create(
            [
                'description' => 'Some description',
                'user_id' => $this->g_user->id,
                'topic_id' => $this->g_topic->id,
            ]
        );
    }

    /**
     * Comment details
     *
     * @return array
     */
    public function commentValid()
    {
        return [
            'description' => 'Some description',
            'images' => []
        ];
    }
}
