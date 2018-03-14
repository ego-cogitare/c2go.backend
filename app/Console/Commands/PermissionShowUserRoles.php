<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class PermissionShowUserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:show-user-roles {user_email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show user roles';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach(User::where('email', $this->argument('user_email'))->firstOrFail()->getRoleNames() as $roleName) {
            $this->line($roleName);
        }
    }
}