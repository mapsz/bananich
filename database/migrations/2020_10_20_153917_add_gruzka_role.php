<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddGruzkaRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $permission = Permission::create(['name' => 'gruzka_panel']);

        Role::create(['name' => 'collector']);
        $roles      = Role::where('name', 'admin')->orWhere('name','collector')->get();
        
        $permission->syncRoles($roles);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        $permission = Permission::where('name', 'gruzka_panel')->first();

        $collectorRole  = Role::where('name', 'collector')->first();
        $adminRole      = Role::where('name', 'admin')->first();

        $permission->removeRole($collectorRole);
        $permission->removeRole($adminRole);

        $permission->delete();
        $collectorRole->delete();
    }
}
