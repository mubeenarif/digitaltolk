<?php

namespace DTApi\Repository;

interface BookingRepositoryInterface 
{
    public function getUsersJobs($user_id);

    public function getAll($request);

    public function store($authenticatedUser, $data);

    public function updateJob($id, $data, $cuser);

}