<?php

namespace App\Support\Enum;

use Filament\Support\Contracts\HasLabel;

enum Roles: string implements HasLabel
{
    case ADMIN = 'admin';

    case CONTENT_MANAGER = 'content_manager';

    case USER_MANAGER = 'user_manager';

    case METADATA_MANAGER = 'metadata_manager';

    public function label(): string
    {
        return self::getLabel();
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ADMIN => __('Administrator'),
            self::CONTENT_MANAGER => __('Content Manager'),
            self::USER_MANAGER => __('User Manager'),
            self::METADATA_MANAGER => __('Metadata Manager'),
        };
    }

    public static function getRolesContentManager(): array
    {
        return [
            self::ADMIN->name,
            self::CONTENT_MANAGER->name,
        ];
    }

    public static function getRolesUserManager(): array
    {
        return [
            self::ADMIN->name,
            self::USER_MANAGER->name,
        ];
    }

    public static function getRolesMetadataManager(): array
    {
        return [
            self::ADMIN->name,
            self::METADATA_MANAGER->name,
        ];
    }

    public static function getRolesCanAccessAdminPanel(): array
    {
        return [
            self::ADMIN->name,
            self::USER_MANAGER->name,
        ];
    }
}
