<?php

namespace DTApi\Http\Controllers\Booking;

use DTApi\Models\Job;
use DTApi\Http\Requests;
use DTApi\Models\Distance;
use Illuminate\Http\Request;
use DTApi\Repository\JobRepository;
use DTApi\Http\Controllers\Controller;
use DTApi\Services\Booking\BookingService;

/**
 * Class JobController
 * @package DTApi\Http\Controllers\Booking
 */
class JobController extends Controller
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
    

    /**
     * @param Request $request
     * @return mixed
     */
    public function immediateJobEmail(Request $request)
    {
        $response = $this->bookingService->immediateJobEmail($request);
        return response($response);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getHistory(Request $request)
    {
        if ($user_id = $request->get('user_id')) {
            $response = $this->bookingService->getHistory($user_id, $request);
            return response($response);
        }

        return null;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function acceptJob(Request $request)
    {
        $data = $request->all();
        $user = $request->__authenticatedUser;
        $response = $this->bookingService->acceptJob($data, $user);
        return response($response);
    }

    public function acceptJobWithId(Request $request)
    {
        $data = $request->get('job_id');
        $user = $request->__authenticatedUser;
        $response = $this->bookingService->acceptJobWithId($data, $user);
        return response($response);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function cancelJob(Request $request)
    {
        $data = $request->all();
        $user = $request->__authenticatedUser;
        $response = $this->bookingService->cancelJob($data, $user);
        return response($response);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function endJob(Request $request)
    {
        $data = $request->all();
        $response = $this->bookingService->endJob($data);
        return response($response);

    }

    public function customerNotCall(Request $request)
    {
        $data = $request->all();
        $response = $this->bookingService->customerNotCall($data);
        return response($response);

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getPotentialJobs(Request $request)
    {
        $data = $request->all();
        $user = $request->__authenticatedUser;
        $response = $this->bookingService->getPotentialJobs($user);
        return response($response);
    }

    public function distanceFeed(Request $request)
    {
        $data = $request->all();
        $response = $this->bookingService->distanceFeed($data);
        return response($response);
    }

    public function reopen(Request $request)
    {
        $data = $request->all();
        $response = $this->bookingService->reopen($data);
        return response($response);
    }

}
