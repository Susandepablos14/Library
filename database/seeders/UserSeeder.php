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
                'email'    => "administrador@example.com",
            ],
            [
            'name'     => 'Admin',
            'email'    => "administrador@example.com",
            'password' => '$2y$10$Ft2dGn92d3YkzYisP0CkwetZKlDRfQgZm0UubikG436QFlNUdXcXq', //admin4321
            ]
        );

        $roles = Role::query()->select(['id'])->whereName('Admin')->pluck('id')->toArray();

        $user->roles()->sync($roles);
    }
}
