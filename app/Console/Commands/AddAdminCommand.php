<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AddAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {name} {email} {phone} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add admin to database';

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
        User::create([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'phone' => $this->argument('phone'),
            'password' => Hash::make($this->argument('password')),
            'role_id' => Role::ADMIN_ID,
            'email_verified_at' => now(),
        ]);

        $this->line('Admin created');
    }
}
