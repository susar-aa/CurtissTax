<?php

namespace Tests\Feature;

use App\Models\Business;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::where('email', 'demo@curtisstax.com')->first();
        $this->assertNotNull($user);

        $response = $this->post('/login', [
            'email' => 'demo@curtisstax.com',
            'password' => 'Demo@123456',
        ]);

        $response->assertRedirect(route('app.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_invalid_password()
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'demo@curtisstax.com',
            'password' => 'WrongPassword',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_suspended_user_cannot_login()
    {
        $suspendedUser = User::create([
            'name' => 'Suspended Account',
            'email' => 'suspended.' . time() . '@test.lk',
            'password' => Hash::make('Secret123!'),
            'status' => 'suspended',
            'locale' => 'en',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $suspendedUser->email,
            'password' => 'Secret123!',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout()
    {
        $user = User::where('email', 'demo@curtisstax.com')->first();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
