<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ClientInformation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_registers_a_new_user_successfully()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
            'nickname' => 'Johnny',
            'middlename' => 'Middle',
            'lastname' => 'Doe',
            'gender' => 'Male',
            'address' => '123 Main St',
            'contact_number' => '1234567890',
            'gcash_number' => '1234567890123456',
        ];

        $response = $this->postJson('/api/tenant-register', $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Registration successful',
                     'data' => [
                         'token' => true, // Just check if the token is returned
                     ],
                 ]);

        // Assert user was created in the database
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);

        // Assert client information was created
        $this->assertDatabaseHas('client_information', [
            'nickname' => 'Johnny',
            'user_id' => User::where('email', 'johndoe@example.com')->first()->id,
        ]);
    }

    /** @test */
    public function it_validates_the_registration_request()
    {
        $response = $this->postJson('/api/tenant-register', []);

        $response->assertStatus(422)
                 ->assertJsonStructure([
                    'message',
                    'errors' => [
                        'name',
                        'email',
                        'password',
                    ],
                 ]);
    }

    /** @test */
    public function it_validates_unique_email()
    {
        User::create([
            'name' => 'Jane Doe',
            'email' => 'janedoe1@example.com',
            'password' => Hash::make('password'),
            'role' => 0,
        ]);

        $response = $this->postJson('/api/tenant-register', [
            'name' => 'John Doe',
            'email' => 'janedoe1@example.com', // Duplicate email
            'password' => 'password',
        ]);

        $response->assertStatus(422)
                 ->assertJson([
                     'message' => 'Validation error',
                     'errors' => [
                         'email' => ['The email has already been taken.'],
                     ],
                 ]);
    }
}
