<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Renting\Domain\Model\Booking;

use Booking\Renting\Domain\Model\AggregateRoot;
use Booking\Renting\Domain\Model\ModelInterface;
use Booking\Tests\Renting\Domain\Event\BookingRequestWasCreated;

class BookingRequest extends AggregateRoot implements ModelInterface
{
    /** @var BookingRequestId */
    private $id;
    /** @var BookingRequestCheckIn */
    private $checkIn;
    /** @var BookingRequestNights */
    private $nights;
    /** @var BookingRequestSellingRate */
    private $sellingRate;
    /** @var BookingRequestMargin */
    private $margin;

    public function id(): BookingRequestId
    {
        return $this->id;
    }

    public function checkIn(): BookingRequestCheckIn
    {
        return $this->checkIn;
    }

    public function nights(): BookingRequestNights
    {
        return $this->nights;
    }

    public function sellingRate(): BookingRequestSellingRate
    {
        return $this->sellingRate;
    }

    public function margin(): BookingRequestMargin
    {
        return $this->margin;
    }

    protected function aggregateId(): string
    {
        return $this->id->toString();
    }

    public function sameIdentityAs(ModelInterface $other): bool
    {
        /* @var self $other */
        return get_class($this) === get_class($other)
            && $this->id->equals($other->id);
    }

    public static function create(
        BookingRequestId $id,
        BookingRequestCheckIn $checkIn,
        BookingRequestNights $nights,
        BookingRequestSellingRate $sellingRate,
        BookingRequestMargin $margin
    ): self {
        $self = new self();
        $self->recordThat(
            BookingRequestWasCreated::with($id, $checkIn, $nights, $sellingRate, $margin)
        );
        return $self;
    }

    public function profitPerNight()
    {
        return (($this->sellingRate->toInt() * $this->margin->toInt()) / 100) / $this->nights->toInt();
    }

    public function profit()
    {
        return $this->sellingRate->toInt() * ($this->margin->toInt() / 100);
    }

    protected function whenBookingRequestWasCreated(BookingRequestWasCreated $event)
    {
        $this->id = $event->id();
        $this->checkIn = $event->checkIn();
        $this->nights = $event->nights();
        $this->sellingRate = $event->sellingRate();
        $this->margin = $event->margin();
    }
}