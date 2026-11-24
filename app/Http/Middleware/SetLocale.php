<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Supported application languages.
     */
    protected array $supportedLocales = ['en', 'si', 'ta'];

    public function handle(Request $request, Closure $next)
    {
        $locale = null;

        // 1. Direct query parameter switch ?lang=si
        if ($request->has('lang') && in_array($request->query('lang'), $this->supportedLocales)) {
            $locale = $request->query('lang');
            Session::put('locale', $locale);

            if (Auth::check()) {
                Auth::user()->update(['locale' => $locale]);
            }
        }

        // 2. Session locale
        if (!$locale && Session::has('locale') && in_array(Session::get('locale'), $this->supportedLocales)) {
            $locale = Session::get('locale');
        }

        // 3. User saved preference in database
        if (!$locale && Auth::check() && in_array(Auth::user()->locale, $this->supportedLocales)) {
            $locale = Auth::user()->locale;
            Session::put('locale', $locale);
        }

        // 4. Default fallback: English
        if (!$locale) {
            $locale = config('app.locale', 'en');
        }

        App::setLocale($locale);
        view()->share('currentLocale', $locale);
        view()->share('supportedLocales', [
            'en' => ['name' => 'English', 'native' => 'English', 'flag' => '🇬🇧'],
            'si' => ['name' => 'Sinhala', 'native' => 'සිංහල', 'flag' => '🇱🇰'],
            'ta' => ['name' => 'Tamil', 'native' => 'தமிழ்', 'flag' => '🇱🇰'],
        ]);

        return $next($request);
    }
}
