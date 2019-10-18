<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Renting\Domain\Model\Booking;

use Booking\Renting\Domain\Model\Booking\BookingRequestCheckIn;

final class CheckInMother
{
    public static function create(string $date): BookingRequestCheckIn
    {
        return BookingRequestCheckIn::fromString($date);
    }

    public static function random(): BookingRequestCheckIn
    {
        return self::create(date(BookingRequestCheckIn::DATE_FORMAT));
    }
}