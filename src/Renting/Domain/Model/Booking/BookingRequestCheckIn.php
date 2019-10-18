<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Renting\Domain\Model\Booking;

use Booking\Renting\Domain\Model\ValueObjectInterface;

class BookingRequestCheckIn implements ValueObjectInterface
{
    CONST DATE_FORMAT = 'Y-m-d';

    private $date;

    private function __construct(string $date)
    {
        $this->guardValidFormatDate($date);
        $this->date = $date;
    }

    private function guardValidFormatDate(string $date): void
    {
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
            throw new \DomainException(sprintf("Invalid checkin date '%s'", $date));
        }
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }

    public function toString(): string
    {
        return $this->date;
    }

    public function __toString(): string
    {
        return $this->date;
    }

    public function equals(ValueObjectInterface $object): bool
    {
        /** @var self $object */
        return get_class($this) === get_class($object)
            && $this->date === $object->date;
    }
}