<?php

namespace App;

enum PermissionsEnum: string
{
    case CREATE_USER = 'create_user';
    case EDIT_USERS = 'edit_users';
    case DELETE_USERS = 'delete_users';
    case CREATE_POSTS = 'create_posts';
    case EDIT_POSTS = 'edit_posts';
    case DELETE_POSTS = 'delete_posts';

    case VIEW_USERS = 'view_users';

    public static function all(): array
    {
        return array_map(fn (self $permission) => $permission->value, self::cases());
    }
}
