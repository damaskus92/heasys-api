<?php

namespace App\Repositories\Interfaces;

interface CheckupProgressRepositoryInterface
{
    public function updateStatus(int $appointmentId, int $serviceId, $status);

    public function findByAppointmentAndService(int $appointmentId, int $serviceId);

    public function findByAppointmentHasAllServiceSuccess(int $appointmentId);
}
