<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    public function test_default_application_language_is_english()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $this->assertEquals('en', App::getLocale());
    }

    public function test_switching_to_sinhala_localizes_ui_strings()
    {
        $response = $this->get('/?lang=si');
        $response->assertStatus(200);
        $this->assertEquals('si', session('locale'));
        $this->assertEquals('si', App::getLocale());

        // Verify Sinhala translated text is present in the response
        $response->assertSee('මුල් පිටුව');
        $response->assertSee('විශේෂාංග');
        $response->assertSee('මිල ගණන්');
    }

    public function test_switching_to_tamil_localizes_ui_strings()
    {
        $response = $this->get('/?lang=ta');
        $response->assertStatus(200);
        $this->assertEquals('ta', session('locale'));
        $this->assertEquals('ta', App::getLocale());

        // Verify Tamil translated text is present in the response
        $response->assertSee('முகப்பு');
        $response->assertSee('அம்சங்கள்');
        $response->assertSee('விலைப்பட்டியல்');
    }
}
