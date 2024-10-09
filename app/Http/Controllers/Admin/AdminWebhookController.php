<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\SettingController;
use App\Http\Resources\WebhookResource;
use App\Models\WebhookCall;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminWebhookController extends SettingController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Setting/Admin/Webhooks', [
            'webhooks' => WebhookResource::collection(
                WebhookCall::orderByDesc('created_at')->get()
            ),
        ]
            + $this->metadata()
        );
    }
}
