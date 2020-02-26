<?php

namespace PhpLab\Core\Enums\Measure;

use PhpLab\Core\Domain\Base\BaseEnum;

class ByteEnum extends BaseEnum
{

    const BIT_PER_BYTE = 8;
    const STEP = 1024;

    const B = 1;
    const KB = self::STEP;
    const MB = self::KB * self::STEP;
    const GB = self::MB * self::STEP;
    const TB = self::GB * self::STEP;
    const PB = self::TB * self::STEP;
    const EB = self::PB * self::STEP;
    const ZB = self::EB * self::STEP;
    const YB = self::ZB * self::STEP;

    public static function allUnits()
    {
        return [
            'B' => 1,
            'KB' => self::KB,
            'MB' => self::MB,
            'GB' => self::GB,
            'TB' => self::TB,
            'PB' => self::PB,
            'EB' => self::EB,
            'ZB' => self::ZB,
            'YB' => self::YB,
        ];
    }

}
