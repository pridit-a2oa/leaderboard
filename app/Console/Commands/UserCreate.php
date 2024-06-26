<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\password;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user account with a role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $prompt = [
            'email' => text(
                label: 'Email address',
                validate: ['email' => 'required|email|unique:users,email']
            ),

            'email_verified_at' => confirm(
                label: 'Email is verified',
                default: false
            ),

            'password' => Hash::make(password(
                label: 'Password',
                required: true
            )),
        ];

        $user = User::create($prompt);

        $role = select(
            label: 'Role',
            options: Role::get()->pluck('name')->toArray(),
            default: 'member'
        );

        $user->syncRoles($role);
    }
}
