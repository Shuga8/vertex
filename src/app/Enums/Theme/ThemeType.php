<?php

namespace App\Enums\Theme;

enum ThemeType: string
{
    case ADMIN = 'admin';
    case FRONTEND = 'frontend';
    case USER = 'user';
    case GLOBAL = 'global';
    case INSTALLER = 'installler';

}
