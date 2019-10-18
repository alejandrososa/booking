<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Renting\Infrastructure\Utils;

use Booking\Renting\Infrastructure\Utils\Calculator;
use Booking\Tests\Shared\UnitTestCase;

class CalculatorTest extends UnitTestCase
{
	private $calculator;

	protected function setUp()
	{
		parent::setUp();
		$this->calculator = new Calculator();
	}

	protected function tearDown()
	{
		parent::tearDown();
		$this->calculator = null;
	}

	public function test_it_should_throw_exception_if_values_are_wrong_to_calculate_average()
	{
		$this->expectException(\Exception::class);

		$this->calculator->average(['one_string', 5, 'another_string']);
	}

	public function test_it_should_throw_exception_if_values_are_wrong_to_get_min_value()
	{
		$this->expectException(\Exception::class);

		$this->calculator->min(['one_string', 5, 'another_string']);
	}

	public function test_it_should_throw_exception_if_values_are_wrong_to_get_max_value()
	{
		$this->expectException(\Exception::class);

		$this->calculator->max(['one_string', 5, 'another_string']);
	}

	public function averageProvider()
	{
		return [
			[[5, 5], 5],
			[[10, 8, 19, 50, 90], 35.4],
			[[200, 150], 175]
		];
	}

	/**
	 * @dataProvider averageProvider
	 * @param $values
	 * @param $expected
	 */
	public function test_it_should_calculate_average($values, $expected)
	{
		$result = $this->calculator->average($values);
		$this->assertEquals($expected, $result);
	}

	public function minProvider()
	{
		return [
			[[5, 7], 5],
			[[10, 8, 19, 50, 90], 8],
			[[200, 150], 150]
		];
	}

	/**
	 * @dataProvider minProvider
	 * @param $values
	 * @param $expected
	 */
	public function test_it_should_get_min_value_of_values($values, $expected)
	{
		$result = $this->calculator->min($values);
		$this->assertEquals($expected, $result);
	}

	public function maxProvider()
	{
		return [
			[[5, 7], 7],
			[[10, 8, 19, 50, 90], 90],
			[[200, 150], 200]
		];
	}

	/**
	 * @dataProvider maxProvider
	 * @param $values
	 * @param $expected
	 */
	public function test_it_should_get_max_value_of_values($values, $expected)
	{
		$result = $this->calculator->max($values);
		$this->assertEquals($expected, $result);
	}
}
