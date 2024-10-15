<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\form;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\select;
use function Laravel\Prompts\table;

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
        $prompt = form()
            ->text(
                label: 'Email address',
                validate: ['email' => 'required|email|unique:users,email'],
                name: 'email'
            )
            ->confirm(
                label: 'Email is verified',
                default: false,
                name: 'email_verified_at'
            )
            ->password(
                label: 'Password',
                required: true,
                transform: fn (string $value) => Hash::make($value),
                name: 'password'
            )
            ->submit();

        $user = User::create([
            'email' => $prompt['email'],
            'email_verified_at' => $prompt['email_verified_at'] ?: null,
            'password' => $prompt['password'],
        ]);

        $role = select(
            label: 'Role',
            options: Role::get()->pluck('name')->toArray(),
            default: 'member'
        );

        $user->syncRoles($role);

        table(
            headers: ['id', 'email', 'password'],
            rows: [$user->only('id', 'email', 'password')]
        );

        outro('User created');
    }
}
