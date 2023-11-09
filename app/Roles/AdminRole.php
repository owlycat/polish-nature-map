<?php

namespace App\Roles;

use App\Enums\Permissions;

class AdminRole extends PermissionRole
{
    protected const ROLE_NAME = 'admin';

    public function getPermissions(): array
    {
        return Permissions::getAllValues();
    }
}
