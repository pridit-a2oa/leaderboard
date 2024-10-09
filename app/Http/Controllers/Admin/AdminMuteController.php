<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\SettingController;
use App\Http\Resources\MuteResource;
use App\Models\Mute;
use App\Models\MuteReason;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminMuteController extends SettingController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Setting/Admin/Mutes', [
            'mutes' => MuteResource::collection(
                Mute::withCount('characters')->get()->sortByDesc('created_at')
            ),
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
