<?php

namespace App\Models\Enums;


class ContactType
{
    const HOME = 'home';
    const WORK = 'work';
    const OTHER = 'other';

    public static function values()
    {
        return [self::HOME, self::WORK, self::OTHER];
    }
}
