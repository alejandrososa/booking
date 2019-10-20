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
use Booking\Renting\Infrastructure\Utils\CombinatorialOptimization;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class GetBookingMaximizeHandler implements MessageSubscriberInterface
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

    /**
     * @var CombinatorialOptimization
     */
    private $optimization;

    public function __construct(
	    Calculator $calculator,
        CombinatorialOptimization $optimization,
        TransformableInterface $transformable
    ) {
        $this->calculator = $calculator;
        $this->optimization = $optimization;
		$this->transformable = $transformable;
    }

    public function __invoke(GetBookingMaximize $query)
    {
        foreach ($query->bookingRequests() as $request) {
            $this->guardFieldsMandatory($request);
        }

        $requests = $query->bookingRequests();
        $requestIds = $this->optimization->getRequestIds($requests, 'request_id');
        $combinationIds = $this->optimization->createCombinations($requestIds);

        $validRequests = [];
        foreach ($combinationIds as $index => $requestIds) {
            if(count($requestIds) === 1) {
                $item = $this->optimization->filterRequestById(current($requestIds), 'request_id', $requests);
                $bookingRequest = $this->populateBookingRequestByArray($item);
                $validRequests[] = [
                    'ids' => array_values($requestIds),
                    'valid' => true,
                    'total_profit' => $bookingRequest->profit()];
            }

            if(count($requestIds) > 1) {
                $items = [];
                foreach ($requestIds as $id) {
                    $items[] = $this->optimization->filterRequestById($id, 'request_id', $requests);
                }

                $rangesDate = array_map(function ($item){
                    return $this->optimization->getDatePeriodByNights($item['check_in'], $item['nights']);
                }, $items);

                if(!($this->optimization->checkOverlappingRangesDate($rangesDate))) {
                    $profit = 0;
                    foreach ($items as $i => $item) {
                        $bookingRequest = $this->populateBookingRequestByArray($item);
                        $profit += $bookingRequest->profit();
                    }
                    $validRequests[] = [
                        'ids' => array_values($requestIds),
                        'valid' => true,
                        'total_profit' => $profit
                    ];
                }
            }
        }

        list($bestProfitRequest, $result) = $this->getBestProfitAndResults($validRequests, $requests);

        $response = new GetBookingMaximizeResponse(
            $bestProfitRequest['ids'],
            $bestProfitRequest['total_profit'],
            $this->calculator->average($result),
            $this->calculator->min($result),
            $this->calculator->max($result)
        );

        return $this->transformable->write($response)->read();
    }

    private function populateBookingRequestByArray(array $request)
    {
        $this->guardFieldsMandatory($request);

        return BookingRequest::create(
            BookingRequestId::fromString($request['request_id']),
            BookingRequestCheckIn::fromString($request['check_in']),
            BookingRequestNights::fromInt($request['nights']),
            BookingRequestSellingRate::fromInt($request['selling_rate']),
            BookingRequestMargin::fromInt($request['margin'])
        );
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

    /**
     * @param array $validRequests
     * @param array $requests
     * @return array
     */
    private function getBestProfitAndResults(array $validRequests, array $requests): array
    {
        $key = $maxProfit = 0;
        foreach ($validRequests as $index => $request) {
            if (isset($request['total_profit']) && $request['total_profit'] >= $maxProfit) {
                $maxProfit = $request['total_profit'];
                $key = $index;
            }
        }

        $bestProfitRequest = isset($validRequests[$key]) ? $validRequests[$key] : [];

        $bestItems = [];
        foreach ($bestProfitRequest['ids'] as $requestId) {
            $bestItems[] = $this->optimization->filterRequestById($requestId, 'request_id', $requests);
        }
        $result = [];
        foreach ($bestItems as $request) {
            $bookingRequest = $this->populateBookingRequestByArray($request);
            $result[] = $bookingRequest->profitPerNight();
        }
        return array($bestProfitRequest, $result);
    }

    public static function getHandledMessages(): iterable
    {
        yield GetBookingMaximize::class;
    }
}