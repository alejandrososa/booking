<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 18/10/19 11:39
 */

namespace Booking\Renting\Application\Transformer;

use Booking\Renting\Application\Booking\GetBookingMaximizeResponse;

class ResponseMaximizeArrayTransformer implements TransformableInterface
{
	/** @var GetBookingMaximizeResponse */
	private $maximizeResponse;

	public function write($data): TransformableInterface
	{
		$this->maximizeResponse = $data;
		return $this;
	}

	public function read()
	{
		if (!$this->maximizeResponse instanceof GetBookingMaximizeResponse) {
			return [];
		}

		return [
			'request_ids' => $this->maximizeResponse->requests(),
			'total_profit' => $this->maximizeResponse->totalProfit(),
			'avg_night' => $this->maximizeResponse->avg(),
			'min_night' => $this->maximizeResponse->min(),
			'max_night' => $this->maximizeResponse->max(),
		];
	}
}