<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Renting\Domain\Model\Booking;

use Booking\Renting\Domain\Model\ValueObjectInterface;

final class BookingRequestId implements ValueObjectInterface
{
    CONST MIN_LENGTH = 3;

    private $id;

    private function __construct(string $id)
    {
        $this->guardMinLength($id);
        $this->id = $id;
    }

    private function guardMinLength(string $id): void
    {
        if (strlen($id) < self::MIN_LENGTH) {
            throw new \DomainException(sprintf("Invalid request id '%s'", $id));
        }
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }

    public function toString(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function equals(ValueObjectInterface $object): bool
    {
        /** @var self $object */
        return get_class($this) === get_class($object)
            && $this->id === $object->id;
    }
}