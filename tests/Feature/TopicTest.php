<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use App\Topic;

class TopicTest extends TestCase
{
    
    use RefreshDatabase;

    /**
     * Test create topic
     *
     * @return void
     */
    public function testCreateTopic()
    {
        $user = $this->createUser();
        $response = $this->actingAs($user, 'api')
            ->post('api/v1/topic', $this->topicValid());
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
     * Test view all topics
     *
     * @return void
     */
    public function testVeiwAllTopics()
    {
        $user = $this->createUser();
        $this->createTopic($user->id);
        $response = $this->actingAs($user, 'api')
            ->get('api/v1/topics');
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
     * Test view topic
     *
     * @return void
     */
    public function testViewTopic()
    {
        $user = $this->createUser();
        $topic = $this->createTopic($user->id);
        $response = $this->actingAs($user, 'api')
            ->get('api/v1/topic/'. $topic->id);
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
     * Test delete topic
     *
     * @return void
     */
    public function testDeleteTopic()
    {
        $user = $this->createUser();
        $topic = $this->createTopic($user->id);
        $response = $this->actingAs($user, 'api')
            ->delete('api/v1/topic/'. $topic->id);
        $response->assertStatus(200)
            ->assertJson(
                [
                    'success' => true,
                    'message' => 'Topic deleted successfully',
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
     * Create topic
     * 
     * @param int $user_id Logged in user id
     *
     * @return object
     */
    public function createTopic($user_id)
    {
        return Topic::create(
            [
                'title' => 'Some title',
                'hashtag' => '#'. str_replace(' ', '', ucwords('Some title')),
                'description' => 'Some description',
                'user_id' => $user_id
            ]
        );
    }

    /**
     * Topic details
     *
     * @return array
     */
    public function topicValid()
    {
        return [
            'title' => 'Some title',
            'description' => 'Some description',
            'images' => []
        ];
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

}
