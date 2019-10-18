<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Renting\Domain\Model\Booking;

use Booking\Renting\Domain\Model\ValueObjectInterface;

class BookingRequestSellingRate implements ValueObjectInterface
{
    private $sellingRate;

    private function __construct(int $sellingRate)
    {
        $this->sellingRate = $sellingRate;
    }

    public static function fromInt(int $sellingRate): self
    {
        return new self($sellingRate);
    }

    public function toInt(): int
    {
        return $this->sellingRate;
    }

    public function equals(ValueObjectInterface $object): bool
    {
        /** @var self $object */
        return get_class($this) === get_class($object)
            && $this->sellingRate === $object->sellingRate;
    }
}