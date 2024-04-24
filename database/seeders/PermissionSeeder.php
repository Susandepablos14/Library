<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{

    const PERMISSIONS = [
        'seguridad',
        'config',

        'permissions.index',
        'permissions.create',
        'permissions.delete',
        'permissions.updated',
        'permissions.getPaginate',

        'roles.index',
        'roles.create',
        'roles.delete',
        'roles.updated',
        'roles.getPaginate',

        'logs.index',
        'logs.getPaginate',

        //usuarios

        'users.index',
        'users.create',
        'users.delete',
        'users.updated',
        'users.getPaginate',

        //paises

        'countries.index',
        'countries.create',
        'countries.delete',
        'countries.updated',
        'countries.getPaginate',

        //categorias

        'categories.index',
        'categories.create',
        'categories.delete',
        'categories.updated',
        'categories.getPaginate',

        //autores

        'authors.index',
        'authors.create',
        'authors.delete',
        'authors.updated',
        'authors.getPaginate',

        //editoriales

        'editorials.index',
        'editorials.create',
        'editorials.delete',
        'editorials.updated',
        'editorials.getPaginate',

        //libros

        'books.index',
        'books.create',
        'books.delete',
        'books.updated',
        'books.getPaginate',

        //copias

        'copies.index',
        'copies.create',
        'copies.delete',
        'copies.updated',
        'copies.getPaginate',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        $permissions = collect(self::PERMISSIONS);
        $permissions_saved = Permission::all();
        $permissions_news = $permissions->filter(
            function ($permission) use ($permissions_saved) {
                return !($permissions_saved->firstWhere('name', $permission));
            }
        )->transform(
            fn ($permission) => [
                'name' => $permission,
                'guard_name' => 'web',
                'created_at' => $now
            ]
        );

        if ($permissions_news->count() > 0) { Permission::insert($permissions_news->toArray());
        }
    }
}
