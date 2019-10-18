<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 18/10/19 11:38
 */

namespace Booking\Renting\Application\Transformer;

interface TransformableInterface
{
	public function write($data): self;
	public function read();
}