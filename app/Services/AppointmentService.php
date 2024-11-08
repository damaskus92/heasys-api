<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Repositories\Interfaces\CheckupProgressRepositoryInterface;

class AppointmentService
{
    public function __construct(
        protected AppointmentRepositoryInterface $appointmentRepo,
        protected CheckupProgressRepositoryInterface $checkupProgressRepo
    ) {}

    public function all()
    {
        return $this->appointmentRepo->all();
    }

    public function find(int $id)
    {
        return $this->appointmentRepo->find($id);
    }

    public function create(array $data)
    {
        return $this->appointmentRepo->create($data);
    }

    public function update(array $data, int $id)
    {
        return $this->appointmentRepo->update($data, $id);
    }

    public function updateServiceStatus(int $appointmentId, int $serviceId, $status)
    {
        $checkupProgress = $this->checkupProgressRepo->updateStatus($appointmentId, $serviceId, $status);

        $allServiceSuccess = $this->checkupProgressRepo->findByAppointmentHasAllServiceSuccess($appointmentId);

        if ($allServiceSuccess) {
            $this->appointmentRepo->updateStatus(StatusEnum::SUCCESS, $appointmentId);
        }

        return $checkupProgress;
    }
}
