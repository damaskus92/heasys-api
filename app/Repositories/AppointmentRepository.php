<?php

namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Models\Appointment;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function all()
    {
        return Appointment::all();
    }

    public function find(int $id)
    {
        return Appointment::findOrFail($id);
    }

    public function create(array $data)
    {
        $data['status'] = StatusEnum::PROCESS;

        return Appointment::create($data);
    }

    public function update(array $data, int $id)
    {
        $appointment = $this->find($id);

        if ($appointment) {
            $appointment->update($data);
        }

        return $appointment;
    }

    public function updateStatus($status, int $id)
    {
        $appointment = $this->update(['status' => $status], $id);

        return $appointment;
    }
}
