<?php

namespace App\Enums;

enum Permissions: string
{
    case VIEW_ADMIN_PANEL = 'view admin panel';
    case RUN_IMPORTERS = 'run importers';
    case VIEW_IMPORTERS = 'view importers';
    case VIEW_TELESCOPE = 'view telescope';
    case VIEW_CATEGORIES = 'view categories';
    case VIEW_STATISTICS = 'view statistics';

    public static function getAllValues(): array
    {
        return array_column(Permissions::cases(), 'value');
    }
}
