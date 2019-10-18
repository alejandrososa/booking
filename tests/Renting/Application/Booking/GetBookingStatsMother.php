<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Renting\Application\Booking;

use Booking\Renting\Application\Booking\GetBookingStats;

final class GetBookingStatsMother
{
    public static function create(array $data): GetBookingStats
    {
        return new GetBookingStats($data);
    }

    public static function random(): GetBookingStats
    {
        $requests = [
            [
                'request_id' => 'bookata_XY123',
                'check_in' => '2020-01-01',
                'nights' => 5,
                'selling_rate' => 200,
                'margin' => 20,
            ],
            [
                'request_id' => 'kayete_PP234',
                'check_in' => '2020-01-04',
                'nights' => 4,
                'selling_rate' => 156,
                'margin' => 22,
            ]
        ];
        return self::create($requests);
    }

    public static function fromArray(array $requests): GetBookingStats
    {
        return self::create($requests);
    }
}