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

	public function requestsToFilterProvider()
	{
		return [
			'empty' => [[[]], 5, 'id', null],
			'first with values' => [
			    [['id' => 'aaa'], ['id' => 'bbb']],
                'aaa', 'id', ['id' => 'aaa']
            ],
            'second with values' => [
                [['id' => 'a'], ['id' => 'b'], ['id' => 'c']],
                'b', 'id', ['id' => 'b']
            ],
            'another with values' => [
                [['id' => 'z'], ['id' => 'zz'], ['id' => 'zzz']],
                'zzz', 'id', ['id' => 'zzz']
            ]
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
		$result = $this->co->filterRequestById($id, $key, $data);
		$this->assertEquals($expected, $result);
	}

    public function test_it_should_get_all_ids_from_data()
    {
        $data = [
            ['id' => 'aaa'],
            ['id' => 'bbb'],
            ['id' => 'ccc'],
        ];
        $result = $this->co->getRequestIds($data, 'id');
        $this->assertEquals(['aaa','bbb','ccc'], $result);
	}

    public function test_it_should_return_date_ranges_by_nights()
    {
        $days = $this->fake()->numberBetween(1, 30);
        $result = $this->co->getDatePeriodByNights(date(CombinatorialOptimization::DATE_FORMAT), $days);

        $d1 = $result[0];
        $d2 = $result[1];
        $interval = date_diff($d1, $d2);

        $this->assertCount(2, $result);
        $this->assertEquals($days, $interval->days);
	}
}
