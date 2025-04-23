<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\SettingController;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminUserController extends SettingController
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
        return Inertia::render('Setting/Admin/Users', [
            'users' => User::with('roles')
                ->without('connections')
                ->orderByDesc('created_at')
                ->get()
                ->toResourceCollection(),
        ]
            + $this->metadata()
        );
    }
}
