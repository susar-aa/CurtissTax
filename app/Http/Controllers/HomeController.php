<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::where('is_active', true)
            ->where('slug', '!=', 'free-trial')
            ->orderBy('sort_order', 'asc')
            ->get(['id', 'name', 'slug', 'description', 'price_lkr_monthly', 'price_lkr_annually', 'max_users', 'max_invoices_per_month', 'max_branches', 'features']);

        return view('public.home', compact('plans'));
    }

    public function pricing()
    {
        $plans = SubscriptionPlan::where('is_active', true)
            ->where('slug', '!=', 'free-trial')
            ->orderBy('sort_order', 'asc')
            ->get(['id', 'name', 'slug', 'description', 'price_lkr_monthly', 'price_lkr_annually', 'max_users', 'max_invoices_per_month', 'max_branches', 'features']);

        return view('public.pricing', compact('plans'));
    }

    public function features()
    {
        return view('public.features');
    }

    public function about()
    {
        return view('public.about');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function terms()
    {
        return view('public.terms');
    }

    public function privacy()
    {
        return view('public.privacy');
    }

    public function setLocale(string $locale)
    {
        if (in_array($locale, ['en', 'si', 'ta'])) {
            session(['locale' => $locale]);
            if (auth()->check()) {
                auth()->user()->update(['locale' => $locale]);
            }
        }

        return redirect()->back();
    }
}
