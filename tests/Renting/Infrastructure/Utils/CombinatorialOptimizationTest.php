<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 18/10/19 14:01
 */

namespace Booking\Tests\Renting\Infrastructure\Utils;

use Booking\Renting\Infrastructure\Utils\CombinatorialOptimization;
use Booking\Tests\Shared\UnitTestCase;
use PHPUnit\Framework\TestCase;

class CombinatorialOptimizationTest extends UnitTestCase
{
	private $co;

	protected function setUp()
	{
		parent::setUp();
		$this->co = new CombinatorialOptimization();
	}

	protected function tearDown()
	{
		parent::tearDown();
		$this->co = null;
	}

	public function combinationsProvider()
	{
		return [
			[[], []],
			[[1,5], [[1], [5], [1,5]]],
			[[7,14, 21], []]
		];
	}

	/**
	 * @dataProvider combinationsProvider
	 * @param $values
	 * @param $expected
	 */
	public function test_it_should_create_all_combinations($values, $expected)
	{
		$result = $this->co->createCombinations($values);
		$this->assertEquals($expected, $result);
	}

	public function requestsToFilterProvider()
	{
		return [
			[[[]], 5, 'id', []],
			[[['id' => 1], ['id' => 9]], 1, 'id', [['id' => 1]]],
			[[['id' => 77], ['id' => 70]], 77, 'id', [['id' => 77]]]
		];
	}

	/**
	 * @dataProvider requestsToFilterProvider
	 * @param $data
	 * @param $id
	 * @param $key
	 * @param $expected
	 */
	public function test_it_should_filter_collection_by_value_and_key($data, $id, $key, $expected)
	{
		$result = $this->co->filterRequestById($data);
		$this->assertEquals($expected, $result);
	}
}
