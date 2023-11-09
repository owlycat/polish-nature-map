<?php

namespace App\Enums;

enum Permissions: string {
    case ViewAdminPanel = 'view admin panel';
    case RunImporters = 'run importers';
    case ViewImporters = 'view importers';

    public static function getAllValues(): array {
        return array_column(Permissions::cases(), 'value');
    }
}
