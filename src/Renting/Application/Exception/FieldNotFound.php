<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Renting\Application\Exception;

final class FieldNotFound extends \Exception
{
	public static function reason($field): self
	{
		return new self(sprintf("Error! Field %s is mandatory", $field));
	}
}
