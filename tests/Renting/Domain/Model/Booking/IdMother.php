<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Renting\Domain\Model\Booking;

use Booking\Renting\Domain\Model\Booking\BookingRequestId;

final class IdMother
{
    public static function create(string $id): BookingRequestId
    {
        return BookingRequestId::fromString($id);
    }

    public static function random(): BookingRequestId
    {
        return self::create(\Ramsey\Uuid\Uuid::uuid4());
    }
}