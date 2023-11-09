<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Roles\AdminRole;

class GrantAdminRoleCommand extends Command
{
    protected $signature = 'user:admin {user}';
    protected $description = 'Make a user an admin';

    public function handle()
    {
        $userIdentifier = $this->argument('user');

        $user = User::where('email', $userIdentifier)->orWhere('id', $userIdentifier)->first();

        if (!$user) {
            $this->error("No user found with ID or email: $userIdentifier");
            return;
        }

        $roleName = (new AdminRole)->getName();
        $user->assignRole($roleName);

        $this->info("User {$user->email} is now an admin.");
    }
}
