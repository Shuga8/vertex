<?php

namespace App\Enums\Theme;

enum ThemeAsset: string
{
    case ADMIN = 'assets/theme/admin';
    case FRONTEND = 'assets/theme/frontend';
    case USER = 'assets/theme/user';
    case GLOBAL = 'assets/theme/global';
    case INSTALLER = 'assets/theme/installer';
    case FRONT = 'assets/theme/font';

}
