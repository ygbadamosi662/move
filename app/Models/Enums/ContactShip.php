<?php

namespace App\Models\Enums;


class ContactShip
{
    const FAM = 'fam';
    const COLLEAGUE = 'colleague';
    const ACQUAINTANCE = 'acquaintance';
    const FRIEND = 'friend';
    const FOE = 'foe';
    const BOSS = 'boss';
    const OTHER = 'other';

    public static function values()
    {
        return [
            self::FAM, 
            self::COLLEAGUE, 
            self::ACQUAINTANCE,
            self::FRIEND,
            self::FOE,
            self::BOSS,
            self::OTHER
        ];
    }
}