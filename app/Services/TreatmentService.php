<?php

namespace App\Services;

use App\Repositories\Interfaces\ServiceRepositoryInterface;

class TreatmentService
{
    public function __construct(
        protected ServiceRepositoryInterface $repository
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
