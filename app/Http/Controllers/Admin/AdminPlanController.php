<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class AdminPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::orderBy('sort_order', 'asc')
            ->paginate(15);

        return view('admin.plans.index', compact('plans'));
    }
}
