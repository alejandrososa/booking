<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Renting\Application\Booking;

use Booking\Renting\Application\Booking\GetBookingStats;
use Booking\Renting\Application\Booking\GetBookingStatsHandler;
use Booking\Renting\Application\Exception\FieldNotFound;
use Booking\Renting\Infrastructure\Utils\Calculator;
use PHPUnit\Framework\TestCase;

class GetBookingStatsHandlerTest extends TestCase
{
    private $handler;

    protected function setUp()
    {
        $this->handler = new GetBookingStatsHandler(
            new Calculator()
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->handler = null;
    }

    private function getBookingStats(): GetBookingStats
    {
        return GetBookingStatsMother::random();
    }

    public function test_validate_that_the_query_exists()
    {
        $this->assertInstanceOf(GetBookingStats::class, $this->getBookingStats());
    }

    public function test_validate_that_an_exception_returns_if_the_calculated_area_not_found()
    {
        $this->expectException(FieldNotFound::class);

        $query = $this->getBookingStats();

        $this->handler->__invoke($query);
    }
}
