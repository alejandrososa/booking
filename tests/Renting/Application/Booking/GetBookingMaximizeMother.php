<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Renting\Application\Booking;

use Booking\Renting\Application\Booking\GetBookingMaximize;

final class GetBookingMaximizeMother
{
    public static function create(array $data): GetBookingMaximize
    {
        return new GetBookingMaximize($data);
    }

    public static function random(): GetBookingMaximize
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
                'margin' => 5,
            ],
            [
                'request_id' => 'atropote_AA930',
                'check_in' => '2020-01-10',
                'nights' => 4,
                'selling_rate' => 150,
                'margin' => 6,
            ],
            [
                'request_id' => 'acme_AAAAA',
                'check_in' => '2020-01-10',
                'nights' => 4,
                'selling_rate' => 160,
                'margin' => 30,
            ]
        ];
        return self::create($requests);
    }

    public static function fromArray(array $requests): GetBookingMaximize
    {
        return self::create($requests);
    }
}