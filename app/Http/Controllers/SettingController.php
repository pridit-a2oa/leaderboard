<?php

namespace App\Http\Controllers;

class SettingController extends Controller
{
    /**
     * Get the page metadata to persist throughout settings.
     *
     * @return array<string, string>
     */
    protected function metadata(): array
    {
        return [
            'name' => 'Settings',
            'icon' => 'bars',
        ];
    }
}
