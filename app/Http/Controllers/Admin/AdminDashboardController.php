<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\SettingController;
use App\Models\Metric;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends SettingController
{
    /**
     * Create a new controller instance.
     */
    public function __construct(Request $request)
    {
        Inertia::share('category', 'admin');

        parent::__construct($request);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $period = CarbonPeriod::create(
            Carbon::today()->subDays(6),
            Carbon::today()
        );

        return Inertia::render('Setting/Admin/Dashboard', [
            'labels' => collect($period)
                ->map(fn ($date) => $date->format('M j'))
                ->slice(0, -1)
                ->push('Today'),
            'data' => Metric::getData($period),
        ] + $this->metadata());
    }
}
