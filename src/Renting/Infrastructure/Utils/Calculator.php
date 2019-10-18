<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Renting\Infrastructure\Utils;

class Calculator
{
    public function average(array $data)
    {
    	$this->guardAllValuesAreNumeric($data);

        $avg = round(array_sum($data) / count($data), 2, PHP_ROUND_HALF_DOWN);
        return (float) number_format($avg, 2);
    }

    public function min(array $data)
    {
		$this->guardAllValuesAreNumeric($data);

		return min($data);
    }

    public function max(array $data)
    {
		$this->guardAllValuesAreNumeric($data);

		return max($data);
    }

	private function guardAllValuesAreNumeric(array $values)
	{
		if (!array_product(array_map('is_numeric', $values))) {
			throw new \Exception('Error! Values are not numeric');
		}
	}
}