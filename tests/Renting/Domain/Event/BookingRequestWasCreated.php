<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Tests\Renting\Domain\Event;

use Booking\Renting\Domain\Model\Booking\BookingRequestCheckIn;
use Booking\Renting\Domain\Model\Booking\BookingRequestId;
use Booking\Renting\Domain\Model\Booking\BookingRequestMargin;
use Booking\Renting\Domain\Model\Booking\BookingRequestNights;
use Booking\Renting\Domain\Model\Booking\BookingRequestSellingRate;
use Prooph\EventSourcing\AggregateChanged;

class BookingRequestWasCreated extends AggregateChanged
{
    private $id;
    private $checkIn;
    private $nights;
    private $sellingRate;
    private $margin;

    public static function with(
        BookingRequestId $id,
        BookingRequestCheckIn $checkIn,
        BookingRequestNights $nights,
        BookingRequestSellingRate $sellingRate,
        BookingRequestMargin $margin
    ): self
    {
        $event = self::occur($id->toString(), [
            'check_in' => $checkIn->toString(),
            'nights' => $nights->toInt(),
            'selling_rate' => $sellingRate->toInt(),
            'margin' => $margin->toInt(),
        ]);

        $event->id = $id;
        $event->checkIn = $checkIn;
        $event->nights = $nights;
        $event->sellingRate = $sellingRate;
        $event->margin = $margin;

        return $event;
    }

    public function id(): BookingRequestId
    {
        if (null === $this->id) {
            $this->id = BookingRequestId::fromString($this->aggregateId());
        }

        return $this->id;
    }

    public function checkIn(): BookingRequestCheckIn
    {
        if (null === $this->checkIn) {
            $this->checkIn = BookingRequestCheckIn::fromString($this->payload['check_in']);
        }

        return $this->checkIn;
    }

    public function nights(): BookingRequestNights
    {
        if (null === $this->nights) {
            $this->nights = BookingRequestNights::fromInt($this->payload['nights']);
        }

        return $this->nights;
    }

    public function sellingRate(): BookingRequestSellingRate
    {
        if (null === $this->sellingRate) {
            $this->sellingRate = BookingRequestSellingRate::fromInt($this->payload['selling_rate']);
        }

        return $this->sellingRate;
    }

    public function margin(): BookingRequestMargin
    {
        if (null === $this->margin) {
            $this->margin = BookingRequestMargin::fromInt($this->payload['margin']);
        }

        return $this->margin;
    }
}