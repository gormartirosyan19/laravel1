<?php

namespace App;

enum RolesEnum:string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case MODERATOR = 'moderator';

    public static function all(): array
    {
        return array_map(fn (self $role) => $role->value, self::cases());
    }
}
