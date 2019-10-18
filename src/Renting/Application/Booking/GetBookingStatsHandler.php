<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Renting\Application\Booking;

use Booking\Renting\Application\Exception\FieldNotFound;
use Booking\Renting\Domain\Model\Booking\BookingRequest;
use Booking\Renting\Domain\Model\Booking\BookingRequestCheckIn;
use Booking\Renting\Domain\Model\Booking\BookingRequestId;
use Booking\Renting\Domain\Model\Booking\BookingRequestMargin;
use Booking\Renting\Domain\Model\Booking\BookingRequestNights;
use Booking\Renting\Domain\Model\Booking\BookingRequestSellingRate;
use Booking\Renting\Infrastructure\Utils\Calculator;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetBookingStatsHandler implements MessageHandlerInterface
{
    /**
     * @var Calculator
     */
    private $calculator;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function __invoke(GetBookingStats $query)
    {
        $list = $this->populateBookingRequests($query);
        $result = [];
        foreach ($list as $booking) {
            /** @var BookingRequest $booking */
            $result[] = $booking->profitPerNight();
        }
        $stats = new \stdClass();
        $stats->avg_night = $this->calculator->average($result);
        $stats->min_night = $this->calculator->min($result);
        $stats->max_night = $this->calculator->max($result);

        return $stats;
    }

    private function populateBookingRequests(GetBookingStats $query): \Generator
    {
        foreach ($query->bookingRequests() as $request) {
            $this->guardFieldsMandatory($request);

            yield BookingRequest::create(
                BookingRequestId::fromString($request['request_id']),
                BookingRequestCheckIn::fromString($request['check_in']),
                BookingRequestNights::fromInt($request['nights']),
                BookingRequestSellingRate::fromInt($request['selling_rate']),
                BookingRequestMargin::fromInt($request['margin'])
            );
        }
    }

    private function guardFieldsMandatory($request): void
    {
        $keysMandatory = ['request_id', 'check_in', 'nights', 'selling_rate', 'margin',];
        $keys = array_keys($request);
        $diff = array_diff($keysMandatory, $keys);
        if (!empty($diff)) {
            throw FieldNotFound::reason(current($diff));
        }
    }
}