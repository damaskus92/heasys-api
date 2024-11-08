<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Repositories\Interfaces\PatientRepositoryInterface;

class PatientRepository implements PatientRepositoryInterface
{
    public function all()
    {
        return Patient::all();
    }

    public function create(array $data)
    {
        return Patient::create($data);
    }
}
