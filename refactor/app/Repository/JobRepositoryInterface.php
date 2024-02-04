<?php

namespace DTApi\Repository;

interface JobRepositoryInterface 
{
    public function immediateJobEmail($request);

    public function getHistory($request);

    public function acceptJob($request);

    public function acceptJobWithId($request);

    public function cancelJob($request);

    public function endJob($request);

    public function customerNotCall($request);

    public function getPotentialJobs($request);

    public function distanceFeed($request);

    public function reopen($request);
}