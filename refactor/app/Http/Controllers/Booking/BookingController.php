<?php

namespace DTApi\Http\Controllers\Booking;

use DTApi\Models\Job;
use DTApi\Http\Requests;
use DTApi\Models\Distance;
use Illuminate\Http\Request;
use DTApi\Repository\BookingRepository;
use DTApi\Http\Controllers\Controller;
use DTApi\Services\Booking\BookingService;

/**
 * Class BookingController
 * @package DTApi\Http\Controllers\Booking
 */
class BookingController extends Controller
{
    
    protected $bookingService;

    /**
     * BookingController constructor.
     * @param BookingService $bookingService
     */
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return response($this->bookingService->index($request));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return response($this->bookingService->show($id));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $response = $this->bookingService->store($request->__authenticatedUser, $data);
        return response($response);

    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        $data = $request->all();
        $response = $this->bookingService->update($id, $data);
        return response($response);
    }

}
