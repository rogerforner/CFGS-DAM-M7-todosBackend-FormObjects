<?php

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TasksTableSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(PermissionSeeder::class);
    }
}
