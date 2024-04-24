<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public const ROLES = [
        'Admin',
        'Librarian',
        'User',
    ];
    public function run()
    {
        $now = now();

        $roles = collect(self::ROLES);
        $roles_saved = Role::all();
        $roles_news = $roles->filter(function ($role) use ($roles_saved) {
            return !($roles_saved->firstWhere('name', $role));
        })->transform(
            fn ($role) => [
                'name' => $role,
                'guard_name' => 'web',
                'created_at' => $now
            ]
        );

        if ($roles_news->count() > 0) Role::insert($roles_news->toArray());

        Role::query()
            ->whereName('Admin')
            ->first()
            ->permissions()
            ->sync(Permission::query()->select(['id'])->pluck('id')->toArray());

        $user = User::find(1);
        $user->assignRole('Admin');
    }
}
