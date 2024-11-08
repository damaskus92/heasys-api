<?php

namespace App\Services;

use App\Repositories\Interfaces\PatientRepositoryInterface;

class PatientService
{
    public function __construct(
        protected PatientRepositoryInterface $repository
    ) {}

    public function all()
    {
        return $this->repository->all();
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }
}
