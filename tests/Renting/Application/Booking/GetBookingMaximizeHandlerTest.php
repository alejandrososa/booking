<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Renting\Application\Booking;

use Booking\Renting\Application\Booking\GetBookingMaximizeHandler;
use Booking\Renting\Application\Booking\GetBookingMaximize;
use Booking\Renting\Application\Exception\FieldNotFound;
use Booking\Renting\Application\Transformer\ResponseMaximizeArrayTransformer;
use Booking\Renting\Infrastructure\Utils\Calculator;
use Booking\Renting\Infrastructure\Utils\CombinatorialOptimization;
use Booking\Tests\Shared\UnitTestCase;

class GetBookingMaximizeHandlerTest extends UnitTestCase
{
    private $handler;

    protected function setUp()
    {
        $this->handler = new GetBookingMaximizeHandler(
            new Calculator(),
			new CombinatorialOptimization(),
			new ResponseMaximizeArrayTransformer()
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->handler = null;
    }

    private function getBookingMaximize(): GetBookingMaximize
    {
        return GetBookingMaximizeMother::random();
    }

    public function test_validate_that_the_query_exists()
    {
        $this->assertInstanceOf(GetBookingMaximize::class, $this->getBookingMaximize());
    }

    public function test_validate_that_an_exception_returns_if_fields_not_found()
    {
        $this->expectException(FieldNotFound::class);

        $query = GetBookingMaximizeMother::fromArray([
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

	public function test_you_can_find_the_best_combination_profit()
	{
		$query = $this->getBookingMaximize();

		$result = $this->handler->__invoke($query);

		$this->assertNotNull($result);
		$this->assertIsArray($result);
		$this->assertArrayHasKey('request_ids', $result);
		$this->assertArrayHasKey('total_profit', $result);
		$this->assertArrayHasKey('avg_night', $result);
		$this->assertArrayHasKey('min_night', $result);
		$this->assertArrayHasKey('max_night', $result);
	}
}
