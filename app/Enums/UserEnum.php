<?php

namespace App\Enums;

enum UserEnum: int
{
    case ADMIN = 1;
    case TEACHER = 2;
    case STUDENT = 3;
}
