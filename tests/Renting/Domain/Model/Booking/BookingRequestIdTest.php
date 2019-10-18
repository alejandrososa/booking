<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Renting\Domain\Model\Booking;

use Booking\Renting\Domain\Model\Booking\BookingRequestId;
use Booking\Renting\Domain\Model\ValueObjectInterface;
use Booking\Tests\Shared\UnitTestCase;

class BookingRequestIdTest extends UnitTestCase
{
    public function test_throw_an_error_if_the_uuid_is_invalid()
    {
        $this->expectException(\DomainException::class);
        $id = $this->fake()->uuid;
        $id = substr($id, 0, BookingRequestId::MIN_LENGTH - 1);
        BookingRequestId::fromString($id);
    }

    public function test_it_create_uuid_from_string()
    {
        $uuidFake = $this->fake()->uuid;
        $uuid = BookingRequestId::fromString($uuidFake);

        $this->assertSame($uuidFake, $uuid->toString());
    }

    /**
     * @depends test_it_create_uuid_from_string
     */
    public function test_it_can_be_compared()
    {
        $uuid = $uuidCloned = $this->fake()->uuid;
        $anotherTitle = $this->fake()->uuid;

        $first = BookingRequestId::fromString($uuid);
        $second = BookingRequestId::fromString($uuidCloned);
        $third = BookingRequestId::fromString($anotherTitle);
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

    public function test_it_can_cast_to_string()
    {
        $uuid = $this->fake()->uuid;
        $BookingRequestId = BookingRequestId::fromString($uuid);
        $this->assertSame($uuid, (string)$BookingRequestId);
    }
}
