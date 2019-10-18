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
use Booking\Renting\Application\Transformer\ResponseStatsArrayTransformer;
use Booking\Renting\Infrastructure\Utils\Calculator;
use Booking\Tests\Shared\UnitTestCase;

class GetBookingStatsHandlerTest extends UnitTestCase
{
    private $handler;

    protected function setUp()
    {
        $this->handler = new GetBookingStatsHandler(
            new Calculator(),
			new ResponseStatsArrayTransformer()
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

    public function test_validate_that_an_exception_returns_if_fields_not_found()
    {
        $this->expectException(FieldNotFound::class);

        $query = GetBookingStatsMother::fromArray([
			[
				'margin' => 22,
			],
			[
				'request_id' => 'kayete_PP234',
				'margin' => 22,
			]
		]);

        $this->handler->__invoke($query);
    }

	public function test_you_can_find_a_calculated_profit_per_night()
	{
		$query = $this->getBookingStats();

		$result = $this->handler->__invoke($query);

		$this->assertNotNull($result);
		$this->assertIsArray($result);
		$this->assertArrayHasKey('avg_night', $result);
		$this->assertArrayHasKey('min_night', $result);
		$this->assertArrayHasKey('max_night', $result);
	}
}
