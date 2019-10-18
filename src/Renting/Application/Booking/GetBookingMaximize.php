<?php
/**
 * Booking, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 19/02/2019 11:55
 */

namespace Booking\Renting\Application\Booking;

class GetBookingMaximize
{
    /**
     * @var array
     */
    private $bookingRequests;

    public function __construct(array $bookingRequests)
    {
        $this->bookingRequests = $bookingRequests;
    }

    public function bookingRequests(): array
    {
        return $this->bookingRequests;
    }
}