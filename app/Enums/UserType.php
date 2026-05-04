<?php

namespace App\Enums;

enum UserType: string
{
    case ADMIN = 'admin';
    case EDITOR = 'editor';
    case USER = 'user';
}