<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionAssignRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:assign-role {user_email} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign role to user';

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
        try {
            User::where('email', $this->argument('user_email'))->firstOrFail()->assignRole(Role::findByName($this->argument('role')));
        } catch (\PDOException $e) {
            if (false !== strpos($e->getMessage(), 'Duplicate entry')) {
                $this->error('User already has this role');
                return;
            }
            throw $e;
        }

    }
}