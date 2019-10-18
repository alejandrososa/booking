<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 18/10/19 11:43
 */

namespace Booking\Renting\Application\Booking;

class GetBookingMaximizeResponse
{
	private $avg;
	private $min;
	private $max;
    private $requests;
    private $totalProfit;

    public function __construct(array $requests, $totalProfit, $avg, $min, $max)
	{
        $this->requests = $requests;
        $this->totalProfit = $totalProfit;
		$this->avg = $avg;
		$this->min = $min;
		$this->max = $max;
    }

	/**
	 * @return int|float
	 */
	public function avg()
	{
		return $this->avg;
	}

	/**
	 * @return int|float
	 */
	public function min()
	{
		return $this->min;
	}

	/**
	 * @return int|float
	 */
	public function max()
	{
		return $this->max;
	}

    public function requests(): array
    {
        return $this->requests;
    }

    public function totalProfit()
    {
        return $this->totalProfit;
    }
}