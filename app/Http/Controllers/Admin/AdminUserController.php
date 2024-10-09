<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\SettingController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminUserController extends SettingController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Setting/Admin/Users', [
            'users' => UserResource::collection(
                User::orderByDesc('created_at')->get()
            ),
        ]
            + $this->metadata()
        );
    }
}
