<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self inactive()
 * @method static self active()
 */
class StatusEnum extends Enum
{
    const MAP_VALUE = [
        'inactive' => 0,
        'active' => 1
    ];
}
