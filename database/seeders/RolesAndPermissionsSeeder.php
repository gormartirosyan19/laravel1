<?php

namespace Database\Seeders;

use App\PermissionsEnum;
use App\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = PermissionsEnum::all();

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole = Role::create(['name' => RolesEnum::ADMIN]);
        $userRole = Role::create(['name' =>  RolesEnum::USER]);
        $moderatorRole = Role::create(['name' =>  RolesEnum::MODERATOR]);

        $adminRole->givePermissionTo(Permission::all());
        $userRole->givePermissionTo('view_users', 'create_posts');
        $moderatorRole->givePermissionTo('view_users', 'edit_posts');
    }
}
