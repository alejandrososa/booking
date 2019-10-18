<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 18/10/19 12:00
 */

namespace Booking\Tests\Renting\Application\Transformer;

use Booking\Renting\Application\Booking\GetBookingMaximizeResponse;
use Booking\Renting\Application\Transformer\ResponseMaximizeArrayTransformer;
use Booking\Renting\Application\Transformer\TransformableInterface;
use Booking\Tests\Shared\UnitTestCase;

class ResponseMaximizeArrayTransformerTest extends UnitTestCase
{
	/** @var TransformableInterface  */
	private $transformer;

	protected function setUp()
	{
		$this->transformer = new ResponseMaximizeArrayTransformer();
	}

	protected function tearDown()
	{
		$this->transformer = null;
	}

	public function providerObjects()
	{
        $request_ids = ['a', 'b'];
		$totalProfit = 8.29;
		$avg = 8.29;
		$min = 8;
		$max = 8.58;

		$expectedResponse = [
			"request_ids"=> $request_ids,
			"total_profit"=> $totalProfit,
			"avg_night"=> $avg,
    		"min_night"=> $min,
    		"max_night"=> $max
		];

		return [
			'array type' => [array('valueOne','valueOne'), []],
			'stdClass object' => [new \stdClass(), []],
			'response object' => [
			    new GetBookingMaximizeResponse(
			        $request_ids, $totalProfit, $avg, $min, $max
                ),
                $expectedResponse
            ]
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