<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Str;

class LoginUserCommand extends Command
{
    protected $signature = 'login:user {role}';
    protected $description = 'Login as a user by role and get a dummy API token';

    public function handle()
    {
        $role = $this->argument('role');

        $user = User::where('role', $role)->where('active', true)->first();

        if (!$user) {
            $this->error("No active user found with role '{$role}', please use either 'user', 'manager', or 'admin'.");
            return Command::FAILURE;
        }

        $token = Str::random(60);
        $user->api_token = $token;
        $user->save();

        $this->info("Logged in as {$user->name} ({$user->email})");
        $this->line("Use this token in your requests:");
        $this->line("Authorization: Bearer {$token}");

        return Command::SUCCESS;
    }
}
