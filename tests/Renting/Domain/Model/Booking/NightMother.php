<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Renting\Domain\Model\Booking;

use Booking\Renting\Domain\Model\Booking\BookingRequestNights;

final class NightMother
{
    public static function create(int $night): BookingRequestNights
    {
        return BookingRequestNights::fromInt($night);
    }

    public static function random(): BookingRequestNights
    {
        return self::create(random_int(1, 30));
    }
}