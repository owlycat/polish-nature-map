<?php

namespace App\Enums;

enum Permissions: string {
    case VIEW_ADMIN_PANEL = 'view admin panel';
    case RUN_IMPORTERS = 'run importers';
    case VIEW_IMPORTERS = 'view importers';

    public static function getAllValues(): array {
        return array_column(Permissions::cases(), 'value');
    }
}
