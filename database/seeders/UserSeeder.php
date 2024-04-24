<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate(
            [
                'email'    => "admin@example.com",
            ],
            [
            'name'     => 'Admin',
            'email'    => "admin@example.com",
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            ]
        );

        $roles = Role::query()->select(['id'])->whereName('Admin')->pluck('id')->toArray();

        $user->roles()->sync($roles);
    }
}
