<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Renting\Domain\Model\Booking;

use Booking\Renting\Domain\Model\ValueObjectInterface;

class BookingRequestMargin implements ValueObjectInterface
{
    private $margin;

    private function __construct(int $margin)
    {
        $this->margin = $margin;
    }

    public static function fromInt(int $margin): self
    {
        return new self($margin);
    }

    public function toInt(): int
    {
        return $this->margin;
    }

    public function equals(ValueObjectInterface $object): bool
    {
        /** @var self $object */
        return get_class($this) === get_class($object)
            && $this->margin === $object->margin;
    }
}