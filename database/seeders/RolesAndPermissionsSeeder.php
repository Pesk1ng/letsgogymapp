<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les rôles
        $superAdmin = Role::create(['name' => 'superadmin']);
        $admin = Role::create(['name' => 'admin']);
        $manager = Role::create(['name' => 'manager']);
        $receptionist = Role::create(['name' => 'receptionist']);
        $controller = Role::create(['name' => 'controller']);

        // Créer les permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage centers']);
        Permission::create(['name' => 'manage services']);
        Permission::create(['name' => 'manage products']);
        Permission::create(['name' => 'manage finances']);
        Permission::create(['name' => 'manage clients']);

        // Assigner les permissions aux rôles
        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(['manage centers', 'manage services', 'manage products', 'manage finances', 'manage clients']);
        $manager->givePermissionTo(['manage services', 'manage products', 'manage finances', 'manage clients']);
        $receptionist->givePermissionTo(['manage clients']);
        $controller->givePermissionTo(['manage finances']);
    }
}
