<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Role::class, 1)->states('admin')->create();
        factory(Role::class, 1)->states('doctor')->create();
        factory(Role::class, 1)->states('clinic')->create();
    }
}