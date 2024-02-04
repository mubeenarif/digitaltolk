<?php

namespace DTApi\Services\Booking;

use DTApi\Repository\BookingRepository;
use DTApi\Repository\NotificationRepository;
use DTApi\Repository\JobRepository;
use Illuminate\Http\Request;

class BookingService
{
    protected $bookingRepository;
    protected $notificationRepository;
    protected $jobRepository;

    public function __construct(
        BookingRepository $bookingRepository,
        NotificationRepository $notificationRepository,
        JobRepository $jobRepository
    )
    {
        $this->bookingRepository = $bookingRepository;
        $this->notificationRepository = $notificationRepository;
        $this->jobRepository = $jobRepository;
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        if($user_id = $request->get('user_id')) {

            $response = $this->bookingRepository->getUsersJobs($user_id);

        }
        elseif($request->__authenticatedUser->user_type == env('ADMIN_ROLE_ID') || $request->__authenticatedUser->user_type == env('SUPERADMIN_ROLE_ID'))
        {
            $response = $this->bookingRepository->getAll($request);
        }

        return response($response);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $job = $this->bookingRepository->with('translatorJobRel.user')->find($id);

        return response($job);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request, $data)
    {
        $response = $this->bookingRepository->store($request->__authenticatedUser, $data);
        return response($response);
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        $cuser = $request->__authenticatedUser;
        $response = $this->bookingRepository->updateJob($id, array_except($data, ['_token', 'submit']), $cuser);

        return response($response);
    }

    public function immediateJobEmail($data)
    {
        $adminSenderEmail = config('app.adminemail');
        return $this->jobRepository->immediateJobEmail($data);
    }

    public function getHistory($user_id, Request $request)
    {
        if ($user_id) {
            return $this->jobRepository->getUsersJobsHistory($user_id, $request);
        }

        return null;
    }

    public function acceptJob($data, $user)
    {
        return $this->jobRepository->acceptJob($data, $user);
    }

    public function acceptJobWithId($jobId, $user)
    {
        return $this->jobRepository->acceptJobWithId($jobId, $user);
    }

    public function cancelJob($data, $user)
    {
        return $this->jobRepository->cancelJobAjax($data, $user);
    }

    public function endJob($data)
    {
        return $this->jobRepository->endJob($data);
    }

    public function customerNotCall($data)
    {
        return $this->jobRepository->customerNotCall($data);
    }

    public function getPotentialJobs($user)
    {
        return $this->jobRepository->getPotentialJobs($user);
    }

    public function distanceFeed($data)
    {
        $distance = $data['distance'] ?? "";
        $time = $data['time'] ?? "";
        $jobid = $data['jobid'] ?? "";
        $session = $data['session_time'] ?? "";
        $flagged = ($data['flagged'] == 'true') ? 'yes' : 'no';
        $manually_handled = ($data['manually_handled'] == 'true') ? 'yes' : 'no';
        $by_admin = ($data['by_admin'] == 'true') ? 'yes' : 'no';
        $admincomment = $data['admincomment'] ?? "";

        if ($flagged == 'yes' && $admincomment == '') {
            return response("Please, add comment");
        }

        if ($time || $distance) {
            Distance::where('job_id', '=', $jobid)->update(['distance' => $distance, 'time' => $time]);
        }

        if ($admincomment || $session || $flagged || $manually_handled || $by_admin) {
            Job::where('id', '=', $jobid)->update([
                'admin_comments' => $admincomment,
                'flagged' => $flagged,
                'session_time' => $session,
                'manually_handled' => $manually_handled,
                'by_admin' => $by_admin
            ]);
        }

        return response('Record updated!');
    }

    public function reopen($data)
    {
        return $this->jobRepository->reopen($data);
    }

    public function resendNotifications($data)
    {
        $job = $this->notificationRepository->find($data['jobid']);
        $job_data = $this->notificationRepository->jobToData($job);

        $this->notificationRepository->sendNotificationTranslator($job, $job_data, '*');

        return response(['success' => 'Push sent']);
    }

    public function resendSMSNotifications($data)
    {
        $job = $this->notificationRepository->find($data['jobid']);
        $job_data = $this->notificationRepository->jobToData($job);

        try {
            $this->notificationRepository->sendSMSNotificationToTranslator($job);
            return response(['success' => 'SMS sent']);
        } catch (\Exception $e) {
            return response(['success' => $e->getMessage()]);
        }
    }

}
