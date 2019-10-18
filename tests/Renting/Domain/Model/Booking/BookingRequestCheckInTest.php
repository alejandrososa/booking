<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Renting\Domain\Model\Booking;

use Booking\Renting\Domain\Model\Booking\BookingRequestCheckIn;
use Booking\Renting\Domain\Model\ValueObjectInterface;
use Booking\Tests\Shared\UnitTestCase;

class BookingRequestCheckInTest extends UnitTestCase
{
    public function test_throw_an_error_if_the_uuid_is_invalid()
    {
        $this->expectException(\DomainException::class);
        BookingRequestCheckIn::fromString('10-11-2000');
    }

    public function test_it_create_checkin_from_date_string()
    {
        $dateExpected = $this->fake()->date(BookingRequestCheckIn::DATE_FORMAT);
        $date = BookingRequestCheckIn::fromString($dateExpected);

        $this->assertSame($dateExpected, $date->toString());
    }

    /**
     * @depends test_it_create_checkin_from_date_string
     */
    public function test_it_can_be_compared()
    {
        $date = $dateCloned = $this->fake()->date(BookingRequestCheckIn::DATE_FORMAT);
        $anotherDate = $this->fake()->date(BookingRequestCheckIn::DATE_FORMAT);

        $first = BookingRequestCheckIn::fromString($date);
        $second = BookingRequestCheckIn::fromString($dateCloned);
        $third = BookingRequestCheckIn::fromString($anotherDate);
        $fourth = new class() implements ValueObjectInterface {
            public function equals(ValueObjectInterface $object): bool
            {
                return false;
            }
        };

        $this->assertTrue($first->equals($second));
        $this->assertFalse($first->equals($third));
        $this->assertFalse($first->equals($fourth));
    }

    public function test_return_valid_uuid()
    {
        $pattern = '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/i';
        $date = $this->fake()->date(BookingRequestCheckIn::DATE_FORMAT);
        $checkin = BookingRequestCheckIn::fromString($date);
        $this->assertRegExp($pattern, $checkin->toString());
    }

    public function test_it_can_cast_to_string()
    {
        $date = $this->fake()->date(BookingRequestCheckIn::DATE_FORMAT);
        $checkin = BookingRequestCheckIn::fromString($date);
        $this->assertSame($date, (string)$checkin);
    }
}
