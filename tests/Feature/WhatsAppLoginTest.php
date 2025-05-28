<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class WhatsAppLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => 'testuser',
            'whatsapp' => '081234567890',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
    }

    /** @test */
    public function user_can_login_with_email()
    {
        $response = $this->post('/login', [
            'login' => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function user_can_login_with_username()
    {
        $response = $this->post('/login', [
            'login' => 'testuser',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function user_can_login_with_whatsapp()
    {
        $response = $this->post('/login', [
            'login' => '081234567890',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function user_can_login_with_whatsapp_62_format()
    {
        $response = $this->post('/login', [
            'login' => '6281234567890',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function user_can_login_with_whatsapp_plus_format()
    {
        $response = $this->post('/login', [
            'login' => '+6281234567890',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function login_fails_with_wrong_password()
    {
        $response = $this->post('/login', [
            'login' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['login']);
    }

    /** @test */
    public function login_fails_with_nonexistent_user()
    {
        $response = $this->post('/login', [
            'login' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['login']);
    }

    /** @test */
    public function where_identifier_scope_works_correctly()
    {
        // Test with email
        $user = User::whereIdentifier('test@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('test@example.com', $user->email);

        // Test with username
        $user = User::whereIdentifier('testuser')->first();
        $this->assertNotNull($user);
        $this->assertEquals('testuser', $user->username);

        // Test with WhatsApp
        $user = User::whereIdentifier('081234567890')->first();
        $this->assertNotNull($user);
        $this->assertEquals('081234567890', $user->whatsapp);

        // Test with WhatsApp 62 format
        $user = User::whereIdentifier('6281234567890')->first();
        $this->assertNotNull($user);
        $this->assertEquals('081234567890', $user->whatsapp);

        // Test with WhatsApp +62 format
        $user = User::whereIdentifier('+6281234567890')->first();
        $this->assertNotNull($user);
        $this->assertEquals('081234567890', $user->whatsapp);
    }

    /** @test */
    public function account_lockout_works_after_failed_attempts()
    {
        // Attempt login with wrong password 5 times
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'login' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        // Next attempt should be locked
        $response = $this->post('/login', [
            'login' => 'test@example.com',
            'password' => 'password123', // Even with correct password
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['login']);
        
        $user = User::where('email', 'test@example.com')->first();
        $this->assertTrue($user->isAccountLocked());
    }
}
