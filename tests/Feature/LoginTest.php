<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Undocumented function
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();
        $this->createUser(); //  Create the user for testing
    }

    /**
     * Register user with valid details
     *
     * @return void
     */
    public function testLoginUserWithValidDetails()
    {
        $response = $this->post('api/v1/login', $this->userDetailsValid());
        $response->assertStatus(200)
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
    public function testRegisterUserWithIncorrectDetails()
    {
        $response = $this->post('api/v1/login', $this->userDetailsIncorrect());
        $response->assertStatus(401)
        ->assertJson([
            'success' => false,
            'message' => 'Invalid login details'
        ])
        ->assertJsonStructure([
            'status',
            'success',
            'message',
            'errors', 
        ]);
    }

    /**
     * Register user with valid details
     *
     * @return void
     */
    public function testRegisterUserWithInvalidDetails()
    {
        $response = $this->post('api/v1/login', $this->userDetailsInvalid());
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
     * Create user
     *
     * @return void
     */
    public function createUser()
    {
        User::create([
            'email'    => 'test@email.com',
            'password' => bcrypt('Password123_'),
            'firstname' => 'John',
            'lastname' => 'Doe',
            'phone_number' => '0899554433',
        ]);
    }

    /**
     * Returns array of valid user data
     *
     * @return array
     */
    public function userDetailsValid()
    {
        return [
            'email'    => 'test@email.com',
            'password' => 'Password123_',
        ];
    }

    /**
     * Returns array of incorrect user data
     *
     * @return array
     */
    public function userDetailsIncorrect()
    {
        return [
            'email'    => 'test@email.com',
            'password' => '12345vt',
        ];
    }

    /**
     * Returns array of invalid user data
     *
     * @return array
     */
    public function userDetailsInvalid()
    {
        return [
            'email'    => 'test@email.com',
        ];
    }
}
