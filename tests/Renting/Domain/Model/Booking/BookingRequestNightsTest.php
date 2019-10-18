<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Renting\Domain\Model\Booking;

use Booking\Renting\Domain\Model\Booking\BookingRequestNights;
use Booking\Renting\Domain\Model\ValueObjectInterface;
use Booking\Tests\Shared\UnitTestCase;

class BookingRequestNightsTest extends UnitTestCase
{
    public function test_it_create_nights_from_int()
    {
        $totalNights = $this->fake()->randomNumber();
        $nights = BookingRequestNights::fromInt($totalNights);

        $this->assertSame($totalNights, $nights->toInt());
    }

    /**
     * @depends test_it_create_nights_from_int
     */
    public function test_it_can_be_compared()
    {
        $nights = $nightsCloned = $this->fake()->randomNumber();
        $anotherNights = $this->fake()->randomNumber();

        $first = BookingRequestNights::fromInt($nights);
        $second = BookingRequestNights::fromInt($nightsCloned);
        $third = BookingRequestNights::fromInt($anotherNights);
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
}
