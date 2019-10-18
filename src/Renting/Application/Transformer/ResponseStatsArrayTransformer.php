<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 18/10/19 11:39
 */

namespace Booking\Renting\Application\Transformer;

use Booking\Renting\Application\Booking\GetBookingStatsResponse;

class ResponseStatsArrayTransformer implements TransformableInterface
{
	/** @var GetBookingStatsResponse */
	private $statsResponse;

	public function write($data): TransformableInterface
	{
		$this->statsResponse = $data;
		return $this;
	}

	public function read()
	{
		if (!$this->statsResponse instanceof GetBookingStatsResponse) {
			return [];
		}

		return [
			'avg_night' => $this->statsResponse->avg(),
			'min_night' => $this->statsResponse->min(),
			'max_night' => $this->statsResponse->max(),
		];
	}
}