<?php

namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Models\CheckupProgress;
use App\Repositories\Interfaces\CheckupProgressRepositoryInterface;

class CheckupProgressRepository implements CheckupProgressRepositoryInterface
{
    public function updateStatus(int $appointmentId, int $serviceId, $status)
    {
        $checkupProgress = $this->findByAppointmentAndService($appointmentId, $serviceId);

        if ($checkupProgress) {
            $checkupProgress->update($status);
        }

        return $checkupProgress;
    }

    public function findByAppointmentAndService(int $appointmentId, int $serviceId)
    {
        return CheckupProgress::where('appointment_id', $appointmentId)
            ->where('service_id', $serviceId)
            ->first();
    }

    public function findByAppointmentHasAllServiceSuccess(int $appointmentId)
    {
        return CheckupProgress::where('appointment_id', $appointmentId)
            ->where('status', '!=', StatusEnum::SUCCESS)
            ->doesntExist();
    }
}
