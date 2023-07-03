<?php

namespace PhpLab\Core\Libs\CheckSum\Helpers;

use PhpLab\Core\Libs\CheckSum\Enums\CheckSumAlgorithmEnum;
use PhpLab\Core\Exceptions\InvalidArgumentException;

class CheckSumHelper
{

    public static function verify($data, int $checkSum, string $algorithm): bool
    {
        $calculatedCheckSum = self::calculate($data, $algorithm);
        return $calculatedCheckSum == $checkSum;
    }

    public static function calculate($data, string $algorithm)
    {
        if ($algorithm == CheckSumAlgorithmEnum::LUHN) {
            $calculatedCheckSum = self::luhnAlgorithm($data);
        } else {
            throw new InvalidArgumentException('Unknown check sum algorithm!');
        }
        return $calculatedCheckSum;
    }

    private static function luhnAlgorithm($digit): int
    {
        $number = strrev(preg_replace('/[^\d]/', '', $digit));
        $sum = 0;
        for ($i = 0, $j = strlen($number); $i < $j; $i++) {
            if (($i % 2) == 0) {
                $val = $number[$i];
            } else {
                $val = $number[$i] * 2;
                if ($val > 9) {
                    $val -= 9;
                }
            }
            $sum += $val;
        }
        $lastNumber = substr($sum, -1);
        $lastNumber = intval($lastNumber);
        return $lastNumber;
    }

}
