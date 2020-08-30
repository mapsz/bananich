<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    // php artisan migrate:fresh --seed --seeder=PermissionsSeeder

    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'edit orders']);
        Permission::create(['name' => 'admin panel']);
        
        // Create roles and assign existing permissions
        //Customer
        $roleCustomer = Role::create(['name' => 'customer']);
        //Admin
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo('admin panel');
        $roleAdmin->givePermissionTo('edit orders');
        //Super-Admin
        $role3 = Role::create(['name' => 'super-admin']);
    }
}
