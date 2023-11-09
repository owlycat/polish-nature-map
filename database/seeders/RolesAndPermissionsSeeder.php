<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Enums\Permissions as PermissionsEnum;
use App\Roles\AdminRole;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // https://spatie.be/docs/laravel-permission/v6/advanced-usage/seeding#content-flush-cache-beforeafter-seeding
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $arrayOfPermissionNames = PermissionsEnum::getAllValues();

        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        $permissions->each(function ($permission) {
            Permission::firstOrCreate($permission);
        });

        $roles = [
            new AdminRole(),
        ];

        foreach($roles as $role) {
            Role::firstOrCreate(['name' => $role->getName()])
            ->givePermissionTo($role->getPermissions());
        }
    }
}
