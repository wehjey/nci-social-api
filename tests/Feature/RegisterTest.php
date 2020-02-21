<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Register user with valid details
     *
     * @return void
     */
    public function testRegisterUserWithValidDetails()
    {
        $response = $this->post('api/v1/register', $this->userDetailsValid());
        $response->assertStatus(201)
        ->assertJson([
            'success' => true,
        ])
        ->assertJsonStructure([
            'status',
            'success',
            'message',
            'access_token',
            'data',
            'token_type', 
            'expires_in'  
        ]);
    }

    /**
     * Register user with valid details
     *
     * @return void
     */
    public function testRegisterUserWithInvalidDetails()
    {
        $response = $this->post('api/v1/register', $this->userDetailsInvalid());
        $response->assertStatus(422)
        ->assertJson([
            'success' => false,
        ])
        ->assertJsonStructure([
            'status',
            'success',
            'message',
            'errors', 
        ]);
    }

    /**
     * Returns array of user data
     *
     * @return array
     */
    public function userDetailsValid()
    {
        return [
            'email'    => 'test@email.com',
            'password' => 'Password123_',
            'password_confirmation' => 'Password123_',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'phone_number' => '0899550433',
        ];
    }

    /**
     * Returns array of user data
     *
     * @return array
     */
    public function userDetailsInvalid()
    {
        return [
            'email'    => 'test@email.com',
            'password' => 'Password123_',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'phone_number' => '0899550433',
        ];
    }
}
