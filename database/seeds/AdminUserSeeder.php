<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

/**
 * Class AdminUserSeeder
 */
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $user = factory(App\User::class)->create([
                    "name" => "Roger Forner",
                    "email" => "ilercapp@rogerforner.com",
                    "password" => bcrypt(env('ADMIN_PWD', '123456'))]
            );

            Role::create(['name' => 'admin']);
            $user->assignRole('admin');


        } catch (\Illuminate\Database\QueryException $exception) {

        }
    }
}