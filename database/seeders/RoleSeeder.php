<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create-categories',
            'read-categories',
            'update-categories',
            'delete-categories',
            'create-products',
            'read-products',
            'update-products',
            'delete-products',
            'create-warehouses',
            'read-warehouses',
            'update-warehouses',
            'delete-warehouses',
            'create-suppliers',
            'read-suppliers',
            'update-suppliers',
            'delete-suppliers',
            'create-purchase-orders',
            'read-purchase-orders',
            'update-purchase-orders',
            'delete-purchase-orders',
            'create-purchases',
            'read-purchases',
            'update-purchases',
            'delete-purchases',
            'create-customers',
            'read-customers',
            'update-customers',
            'delete-customers',
            'create-quotes',
            'read-quotes',
            'update-quotes',
            'delete-quotes',
            'create-sales',
            'read-sales',
            'update-sales',
            'delete-sales',
            'create-movements',
            'read-movements',
            'update-movements',
            'delete-movements',
            'create-transfers',
            'read-transfers',
            'update-transfers',
            'delete-transfers',
            'create-users',
            'read-users',
            'update-users',
            'delete-users',
            'read-top-products',
            'create-roles',
            'read-roles',
            'update-roles',
            'delete-roles',
            'create-permissions',
            'read-permissions',
            'update-permissions',
            'delete-permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());

        Role::create(['name' => 'editor'])->givePermissionTo([
            'create-categories',
            'read-categories',
            'update-categories',
            'delete-categories',
            'create-products',
            'read-products',
            'update-products',
            'delete-products',
            'create-warehouses',
            'read-warehouses',
            'update-warehouses',
            'delete-warehouses',
            'create-suppliers',
            'read-suppliers',
            'update-suppliers',
            'delete-suppliers',
            'create-customers',
            'read-customers',
            'update-customers',
            'delete-customers',
        ]);

        Role::create(['name' => 'viewer'])->givePermissionTo([
            'read-categories',
            'read-products',
            'read-warehouses',
            'read-suppliers',
            'read-purchase-orders',
            'read-purchases',
            'read-customers',
            'read-quotes',
            'read-sales',
            'read-movements',
            'read-transfers',
            'read-users',
            'read-top-products',
        ]);

        User::factory()->create([
            'name' => 'Mateo',
            'email' => 'mateo@correo.com',
            'password' => bcrypt('password'),
        ])->assignRole('admin');
    }
}
