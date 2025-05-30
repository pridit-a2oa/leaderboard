<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\SettingController;
use App\Models\Mute;
use App\Models\MuteReason;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminMuteController extends SettingController
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
        return Inertia::render('Setting/Admin/Mutes', [
            'mutes' => Mute::with('characters')
                ->withCount('characters')
                ->orderByDesc('created_at')
                ->get()
                ->toResourceCollection(),
            'reasons' => MuteReason::get(),
        ]
            + $this->metadata()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Create new mute (patch)

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        // Update mute (post)

        return back();
    }

    /**
     *  Remove the specified resource from storage.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Delete mute (delete)

        return back();
    }
}
