<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Renting\Infrastructure\Utils;

class Calculator
{
    public function average(array $data)
    {
        $avg = round(array_sum($data) / count($data), 2, PHP_ROUND_HALF_DOWN);
        return (float) number_format($avg, 2);
    }

    public function min(array $data)
    {
        return min($data);
    }

    public function max(array $data)
    {
        return max($data);
    }
}