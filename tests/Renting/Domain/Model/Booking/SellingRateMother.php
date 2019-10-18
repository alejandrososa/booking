<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Renting\Domain\Model\Booking;

use Booking\Renting\Domain\Model\Booking\BookingRequestSellingRate;

final class SellingRateMother
{
    public static function create(int $margin): BookingRequestSellingRate
    {
        return BookingRequestSellingRate::fromInt($margin);
    }

    public static function random(): BookingRequestSellingRate
    {
        return self::create(random_int(100, 250));
    }
}