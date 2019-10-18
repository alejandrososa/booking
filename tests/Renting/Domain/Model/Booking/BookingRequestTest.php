<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Renting\Domain\Model\Booking;

use Booking\Renting\Domain\Model\Booking\BookingRequest;
use Booking\Tests\Renting\Domain\Event\BookingRequestWasCreated;
use Booking\Tests\Shared\UnitTestCase;

class BookingRequestTest extends UnitTestCase
{
    /** @var BookingRequest */
    private $bookingRequest;

    protected function setUp()
    {
        parent::setUp();
        $this->bookingRequest = $this->createBookingRequest();
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->bookingRequest = null;
    }

    private function createBookingRequest(
        ?string $id = null,
        ?string $checkIn = null,
        ?int $nights = null,
        ?int $sellingRate = null,
        ?int $margin = null
    ) {
        $id = empty($id) ? IdMother::random() : IdMother::create($id);
        $checkIn = empty($checkIn) ? CheckInMother::random() : CheckInMother::create($checkIn);
        $nights = empty($nights) ? NightMother::random() : NightMother::create($nights);
        $sellingRate = empty($sellingRate) ? SellingRateMother::random() : SellingRateMother::create($sellingRate);
        $margin = empty($margin) ? MarginMother::random() : MarginMother::create($margin);

        return BookingRequest::create(
            $id, $checkIn, $nights, $sellingRate, $margin
        );
    }

    public function test_validate_that_one_booking_request_is_equal_to_another()
    {
        $this->assertTrue($this->bookingRequest->sameIdentityAs($this->bookingRequest));
    }

    public function test_validate_that_an_event_is_launched_when_a_booking_request_is_created()
    {
        $bookingRequest = $this->createBookingRequest();
        $events = $this->popRecordedEvent($bookingRequest);

        $this->assertCount(1, $events);

        /** @var BookingRequestWasCreated $event */
        $event = $events[0];

        $this->assertSame(BookingRequestWasCreated::class, $event->messageName());
        $this->assertTrue($bookingRequest->id()->equals($event->id()));
        $this->assertTrue($bookingRequest->checkIn()->equals($event->checkIn()));
        $this->assertTrue($bookingRequest->nights()->equals($event->nights()));
        $this->assertTrue($bookingRequest->sellingRate()->equals($event->sellingRate()));
        $this->assertTrue($bookingRequest->margin()->equals($event->margin()));
    }

    public function requestProvider()
    {
        $br1 = $this->createBookingRequest('bookata_XY123', '2020-01-01', 5, 200, 20);
        $br2 = $this->createBookingRequest('kayete_PP234', '2020-01-04', 4, 156, 22);
        $br3 = $this->createBookingRequest('bookata_XY123', '2020-01-01', 1, 50, 20);
        $br4 = $this->createBookingRequest('kayete_PP234', '2020-01-04', 1, 55, 22);
        $br5 = $this->createBookingRequest('kayete_PP234', '2020-01-04', 1, 49, 21);
        return [
            [$br1, 8],
            [$br2, 8.58],
            [$br3, 10],
            [$br4, 12.1],
            [$br5, 10.29],
        ];
    }

    /**
     * @dataProvider requestProvider
     */
    public function test_it_should_return_valid_profit($bookingRequest, $expected)
    {
        /** @var BookingRequest $bookingRequest */
        $this->assertEquals($expected, $bookingRequest->profitPerNight());
    }
}
