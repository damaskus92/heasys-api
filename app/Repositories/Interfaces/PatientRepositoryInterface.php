<?php

namespace App\Repositories\Interfaces;

interface PatientRepositoryInterface
{
    public function all();

    public function create(array $data);
}
