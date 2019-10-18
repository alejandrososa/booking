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

class BookingRequestMarginTest extends UnitTestCase
{
    public function test_it_create_margin_from_int()
    {
        $marginExpected = $this->fake()->randomNumber();
        $margin = BookingRequestMargin::fromInt($marginExpected);

        $this->assertSame($marginExpected, $margin->toInt());
    }

    /**
     * @depends test_it_create_margin_from_int
     */
    public function test_it_can_be_compared()
    {
        $margin = $marginCloned = $this->fake()->randomNumber();
        $anotherMargin = $this->fake()->randomNumber();

        $first = BookingRequestMargin::fromInt($margin);
        $second = BookingRequestMargin::fromInt($marginCloned);
        $third = BookingRequestMargin::fromInt($anotherMargin);
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
