<?php

namespace App\Services;

use App\Repositories\Interfaces\DiagnoseRepositoryInterface;

class DiagnoseService
{
    public function __construct(
        protected DiagnoseRepositoryInterface $repository
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
