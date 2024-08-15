<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //Roles
        $role1 = Role::create(['id' => 1, 'name' => 'Superadmin']);
        //End of roles

        //Permissions
        Permission::create(['name' => 'Show Pengaturan', 'guard_name' => 'web', 'menu_name' => 'Pengaturan', 'action_name' => 'Show']);
        Permission::create(['name' => 'Show Manajemen Permissions', 'guard_name' => 'web', 'menu_name' => 'Permissions', 'action_name' => 'Show']);
        Permission::create(['name' => 'Show Manajemen User', 'guard_name' => 'web', 'menu_name' => 'Users', 'action_name' => 'Show']);
        Permission::create(['name' => 'Show Access Utilities', 'guard_name' => 'web', 'menu_name' => 'Pengaturan', 'action_name' => 'Show']);
        Permission::create(['name' => 'Show Manajemen Menu', 'guard_name' => 'web', 'menu_name' => 'Menu', 'action_name' => 'Show']);
        Permission::create(['name' => 'Show Master Data', 'guard_name' => 'web', 'menu_name' => 'Master Data', 'action_name' => 'Show']);
        Permission::create(['name' => 'Edit Menu', 'guard_name' => 'web', 'menu_name' => 'Menu', 'action_name' => 'Edit']);
        Permission::create(['name' => 'Store Menu', 'guard_name' => 'web', 'menu_name' => 'Menu', 'action_name' => 'Store']);
        Permission::create(['name' => 'Update Menu', 'guard_name' => 'web', 'menu_name' => 'Menu', 'action_name' => 'Update']);
        Permission::create(['name' => 'Delete Menu', 'guard_name' => 'web', 'menu_name' => 'Menu', 'action_name' => 'Delete']);
        Permission::create(['name' => 'Edit Permissions', 'guard_name' => 'web', 'menu_name' => 'Permissions', 'action_name' => 'Edit']);
        Permission::create(['name' => 'Store Permissions', 'guard_name' => 'web', 'menu_name' => 'Permissions', 'action_name' => 'Store']);
        Permission::create(['name' => 'Update Permissions', 'guard_name' => 'web', 'menu_name' => 'Permissions', 'action_name' => 'Update']);
        Permission::create(['name' => 'Delete Permissions', 'guard_name' => 'web', 'menu_name' => 'Permissions', 'action_name' => 'Delete']);
        Permission::create(['name' => 'Show Role', 'guard_name' => 'web', 'menu_name' => 'Roles', 'action_name' => 'Show']);
        Permission::create(['name' => 'Store Role', 'guard_name' => 'web', 'menu_name' => 'Roles', 'action_name' => 'Store']);
        Permission::create(['name' => 'Edit Role', 'guard_name' => 'web', 'menu_name' => 'Roles', 'action_name' => 'Edit']);
        Permission::create(['name' => 'Update Role', 'guard_name' => 'web', 'menu_name' => 'Roles', 'action_name' => 'Update']);
        Permission::create(['name' => 'Delete Role', 'guard_name' => 'web', 'menu_name' => 'Roles', 'action_name' => 'Delete']);
        Permission::create(['name' => 'Store User', 'guard_name' => 'web', 'menu_name' => 'Users', 'action_name' => 'Store']);
        Permission::create(['name' => 'Edit User', 'guard_name' => 'web', 'menu_name' => 'Users', 'action_name' => 'Edit']);
        Permission::create(['name' => 'Update User', 'guard_name' => 'web', 'menu_name' => 'Users', 'action_name' => 'Update']);
        Permission::create(['name' => 'Delete User', 'guard_name' => 'web', 'menu_name' => 'Users', 'action_name' => 'Delete']);
        Permission::create(['name' => 'Show Manajemen Role', 'guard_name' => 'web', 'menu_name' => 'Roles', 'action_name' => 'Show']);
        Permission::create(['name' => 'Show Beranda', 'guard_name' => 'web', 'menu_name' => 'Beranda', 'action_name' => 'Show']);

        //Give Permission to Role
        $role1->givePermissionTo('Show Pengaturan');
        $role1->givePermissionTo('Show Manajemen Permissions');
        $role1->givePermissionTo('Show Manajemen User');
        $role1->givePermissionTo('Show Access Utilities');
        $role1->givePermissionTo('Show Manajemen Menu');
        $role1->givePermissionTo('Show Master Data');
        $role1->givePermissionTo('Edit Menu');
        $role1->givePermissionTo('Store Menu');

        $role1->givePermissionTo('Update Menu');
        $role1->givePermissionTo('Delete Menu');
        $role1->givePermissionTo('Edit Permissions');
        $role1->givePermissionTo('Store Permissions');
        $role1->givePermissionTo('Update Permissions');
        $role1->givePermissionTo('Delete Permissions');

        $role1->givePermissionTo('Show Manajemen Role');
        $role1->givePermissionTo('Edit Role');
        $role1->givePermissionTo('Store Role');
        $role1->givePermissionTo('Update Role');
        $role1->givePermissionTo('Delete Role');

        $role1->givePermissionTo('Show Manajemen User');
        $role1->givePermissionTo('Edit User');
        $role1->givePermissionTo('Store User');
        $role1->givePermissionTo('Update User');
        $role1->givePermissionTo('Delete User');

        $role1->givePermissionTo('Show Beranda');

        $user = User::create([
            'name' => 'Saya Super Admin',
            'email' => 'superadmin@arz.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('Superadmin');
    }
}
