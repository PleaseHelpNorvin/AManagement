<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker; // Added WithFaker trait
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_admin_with_correct_credentials_and_role()
    {
        // Arrange: Create a test user with Faker-generated data
        $adminUser = User::factory()->create([
            'email' => $this->faker->unique()->safeEmail(), // Using Faker for email
            'password' => Hash::make('password'),
            'role' => 1, // Assuming 1 is the numeric value for admin role
            'is_logged_in' => false,
        ]);

        // Act: Attempt to log in with Faker-generated email
        $response = $this->postJson('/api/admin-login', [
            'email' => $adminUser->email,
            'password' => 'password',
        ]);

        // Assert: Check if the login was successful
        $response->assertStatus(200);
        $response->assertJsonStructure(['token', 'role', 'is_logged_in']);
        $this->assertEquals('admin', $response['role']);
    }

    public function test_admin_with_wrong_credentials_and_role()
    {
        $adminUser = User::factory()->create([
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role' => 0,
            'is_logged_in' => false,
        ]);

        $response = $this->postJson('/api/admin-login', [
            'email' => $adminUser->email,
            'password' => $this->faker->password()
        ]);

        $response->assertStatus(403);
        $response->assertJsonStructure(['message']);
    }


    //clienttesting

    
}
