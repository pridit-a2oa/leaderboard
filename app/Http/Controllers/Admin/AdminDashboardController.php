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
    public function index(Request $request): Response
    {
        $validated = $request->validate([
            'period' => [
                'sometimes',
                'integer',
                'in:14',
                function ($attribute, $value, $fail) {
                    if (! auth()->check()) {
                        $fail('Unauthenticated');
                    }

                    if (! auth()->user()->hasRole('admin')) {
                        $fail('Restricted access');
                    }
                },
            ],
        ]);

        $period = CarbonPeriod::create(
            Carbon::today()->subDays(($validated['period'] ?? 7) - 1),
            Carbon::today()
        );

        return Inertia::render('Setting/Admin/Dashboard', [
            'labels' => collect($period)
                ->map(fn ($date) => $date->format('M j')),
            'data' => Metric::getData($period) ?: collect(['Returning Players', 'New Players'])
                ->map(fn ($label) => [
                    'label' => $label,
                    'data' => collect($period)->map(fn () => 0)->all(),
                ])->all(),
            'period' => (int) $request->query('period'),
        ] + $this->metadata());
    }
}
