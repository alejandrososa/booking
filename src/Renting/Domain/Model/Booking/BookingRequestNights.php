<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Renting\Domain\Model\Booking;

use Booking\Renting\Domain\Model\ValueObjectInterface;

final class BookingRequestNights implements ValueObjectInterface
{
    private $nights;

    private function __construct(int $nights)
    {
        $this->nights = $nights;
    }

    public static function fromInt(int $nights): self
    {
        return new self($nights);
    }

    public function toInt(): int
    {
        return $this->nights;
    }

    public function equals(ValueObjectInterface $object): bool
    {
        /** @var self $object */
        return get_class($this) === get_class($object)
            && $this->nights === $object->nights;
    }
}