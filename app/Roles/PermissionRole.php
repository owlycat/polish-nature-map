<?php

namespace App\Roles;

abstract class PermissionRole {

    public function getName(): string {
        return static::ROLE_NAME;
    }

    abstract public function getPermissions(): array;
}
