<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Renting\Application\Booking;

use Booking\Renting\Application\Exception\FieldNotFound;
use Booking\Renting\Application\Transformer\TransformableInterface;
use Booking\Renting\Domain\Model\Booking\BookingRequest;
use Booking\Renting\Domain\Model\Booking\BookingRequestCheckIn;
use Booking\Renting\Domain\Model\Booking\BookingRequestId;
use Booking\Renting\Domain\Model\Booking\BookingRequestMargin;
use Booking\Renting\Domain\Model\Booking\BookingRequestNights;
use Booking\Renting\Domain\Model\Booking\BookingRequestSellingRate;
use Booking\Renting\Infrastructure\Utils\Calculator;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetBookingMaximizeHandler implements MessageHandlerInterface
{
	const FIELDS_MANDATORY = ['request_id', 'check_in', 'nights', 'selling_rate', 'margin'];

	/**
     * @var Calculator
     */
    private $calculator;

	/**
	 * @var TransformableInterface
	 */
	private $transformable;

	public function __construct(Calculator $calculator, TransformableInterface $transformable)
    {
        $this->calculator = $calculator;
		$this->transformable = $transformable;
	}

    public function __invoke(GetBookingStats $query)
    {
        echo '<pre>';print_r([__CLASS__,__LINE__,__METHOD__, ]);echo '</pre>';die();
        $list = $this->populateBookingRequests($query);
        $result = [];
        foreach ($list as $booking) {
            /** @var BookingRequest $booking */
            $result[] = $booking->profitPerNight();
        }


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
        $keysMandatory = self::FIELDS_MANDATORY;
        $keys = array_keys($request);
        $diff = array_diff($keysMandatory, $keys);
        if (!empty($diff)) {
            throw FieldNotFound::reason(current($diff));
        }
    }
}