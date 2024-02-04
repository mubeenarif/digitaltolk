<?php

namespace DTApi\Http\Controllers\Booking;

use DTApi\Models\Job;
use DTApi\Http\Requests;
use DTApi\Models\Distance;
use Illuminate\Http\Request;
use DTApi\Repository\NotificationRepository;
use DTApi\Http\Controllers\Controller;
use DTApi\Services\Booking\BookingService;

/**
 * Class NotificationController
 * @package DTApi\Http\Controllers\Booking
 */
class NotificationController extends Controller
{

    protected $bookingService;

    /**
     * JobController constructor.
     * @param BookingService $bookingService
     */
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function resendNotifications(Request $request)
    {
        $data = $request->all();
        $response = $this->bookingService->resendNotifications($data);
        return response($response);
    }

    /**
     * Sends SMS to Translator
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function resendSMSNotifications(Request $request)
    {
        $data = $request->all();
        $response = $this->bookingService->resendSMSNotifications($data);
        return response($response);
    }

}
