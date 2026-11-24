<?php

namespace Tests\Feature;

use App\Models\SubscriptionPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    /**
     * Test all public marketing routes return 200 OK.
     */
    public function test_all_public_pages_render_successfully(): void
    {
        $routes = [
            '/',
            '/pricing',
            '/features',
            '/about',
            '/contact',
            '/terms',
            '/privacy',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    /**
     * Test home page renders key SaaS content and dynamic subscription plans.
     */
    public function test_home_page_contains_expected_content_and_plans(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee(__('app.brand'));
        $response->assertSee('Starter');
        $response->assertSee('Professional');
        $response->assertSee('Enterprise');
        $response->assertSee('CTX-2026-0042');
        $response->assertSee('102938475');
    }

    /**
     * Test pricing page displays LKR amounts and toggle structure.
     */
    public function test_pricing_page_displays_active_plans(): void
    {
        $response = $this->get('/pricing');
        $response->assertStatus(200);
        $response->assertSee('Starter');
        $response->assertSee('2,500');
        $response->assertSee('Professional');
        $response->assertSee('5,000');
        $response->assertSee('Enterprise');
        $response->assertSee('12,500');
    }

    /**
     * Test trilingual locale switching and persistent session.
     */
    public function test_locale_switcher_works_for_all_supported_languages(): void
    {
        // Sinhala
        $responseSi = $this->get(route('locale.set', 'si'));
        $responseSi->assertRedirect();
        $this->assertEquals('si', session('locale'));

        $homeSi = $this->withSession(['locale' => 'si'])->get('/');
        $homeSi->assertStatus(200);
        $homeSi->assertSee('නොමිලේ අත්හදා බලන්න'); // nav_register in Sinhala

        // Tamil
        $responseTa = $this->get(route('locale.set', 'ta'));
        $responseTa->assertRedirect();
        $this->assertEquals('ta', session('locale'));

        $homeTa = $this->withSession(['locale' => 'ta'])->get('/');
        $homeTa->assertStatus(200);
        $homeTa->assertSee('இலவச சோதனை'); // nav_register in Tamil

        // English
        $responseEn = $this->get(route('locale.set', 'en'));
        $responseEn->assertRedirect();
        $this->assertEquals('en', session('locale'));

        $homeEn = $this->withSession(['locale' => 'en'])->get('/');
        $homeEn->assertStatus(200);
        $homeEn->assertSee('Start Free Trial'); // nav_register in English
    }

    /**
     * Test guest authentication links are present.
     */
    public function test_guest_nav_links_point_to_valid_routes(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee(route('login'));
        $response->assertSee(route('register'));
    }
}
