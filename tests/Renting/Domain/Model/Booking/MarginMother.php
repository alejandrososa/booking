<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Renting\Domain\Model\Booking;

use Booking\Renting\Domain\Model\Booking\BookingRequestMargin;

final class MarginMother
{
    public static function create(int $margin): BookingRequestMargin
    {
        return BookingRequestMargin::fromInt($margin);
    }

    public static function random(): BookingRequestMargin
    {
        return self::create(random_int(1, 30));
    }
}