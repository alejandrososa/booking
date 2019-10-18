<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 18/10/19 12:00
 */

namespace Booking\Tests\Renting\Application\Transformer;

use Booking\Renting\Application\Booking\GetBookingStatsResponse;
use Booking\Renting\Application\Transformer\ResponseStatsArrayTransformer;
use Booking\Renting\Application\Transformer\TransformableInterface;
use Booking\Tests\Shared\UnitTestCase;

class ResponseStatsArrayTransformerTest extends UnitTestCase
{
	/** @var TransformableInterface  */
	private $transformer;

	protected function setUp()
	{
		$this->transformer = new ResponseStatsArrayTransformer();
	}

	protected function tearDown()
	{
		$this->transformer = null;
	}

	public function providerObjects()
	{
		$avg = 8.29;
		$min = 8;
		$max = 8.58;

		$expectedResponse = [
			"avg_night"=> $avg,
    		"min_night"=> $min,
    		"max_night"=> $max
		];

		return [
			'array type' => [array('valueOne','valueOne'), []],
			'stdClass object' => [new \stdClass(), []],
			'response object' => [new GetBookingStatsResponse($avg, $min, $max), $expectedResponse]
		];
	}

	/**
	 * @dataProvider providerObjects
	 * @param $object
	 * @param $expectedResult
	 */
	public function test_it_can_transformer_objects($object, $expectedResult)
	{
		$result = $this->transformer->write($object)->read();
		$this->assertSame($expectedResult, $result);
	}
}