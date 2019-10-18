<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Renting\Ui\Api\Controller;

use Booking\Renting\Application\Booking\GetBookingStats;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class GetBookingStatsController
{
    public function __invoke(Request $request, MessageBusInterface $bus)
    {
        try {
            $bookings = json_decode($request->getContent(), true);
            $envelope = $bus->dispatch(new GetBookingStats($bookings));
            $handledStamp = $envelope->last(HandledStamp::class);
        } catch (\Exception $e) {
            return new JsonResponse(['message'=> $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($handledStamp->getResult(), Response::HTTP_OK);
    }
}