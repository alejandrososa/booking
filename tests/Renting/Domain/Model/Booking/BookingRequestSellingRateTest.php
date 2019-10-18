<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Renting\Domain\Model\Booking;

use Booking\Renting\Domain\Model\Booking\BookingRequestMargin;
use Booking\Renting\Domain\Model\ValueObjectInterface;
use Booking\Tests\Shared\UnitTestCase;

class BookingRequestSellingRateTest extends UnitTestCase
{
    public function test_it_create_sellingrate_from_int()
    {
        $sellingRateExpected = $this->fake()->randomNumber();
        $requestMargin = BookingRequestMargin::fromInt($sellingRateExpected);

        $this->assertSame($sellingRateExpected, $requestMargin->toInt());
    }

    /**
     * @depends test_it_create_sellingrate_from_int
     */
    public function test_it_can_be_compared()
    {
        $sellingRate = $sellingRateCloned = $this->fake()->randomNumber();
        $anotherSellingRateMargin = $this->fake()->randomNumber();

        $first = BookingRequestMargin::fromInt($sellingRate);
        $second = BookingRequestMargin::fromInt($sellingRateCloned);
        $third = BookingRequestMargin::fromInt($anotherSellingRateMargin);
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
