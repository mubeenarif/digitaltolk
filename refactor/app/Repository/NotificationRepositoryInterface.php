<?php

namespace DTApi\Repository;

interface NotificationRepositoryInterface 
{
    public function sendNotificationTranslator($data);
    public function sendSMSNotificationToTranslator($data);
}