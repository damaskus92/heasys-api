<?php

namespace App\Repositories;

use App\Models\Diagnose;
use App\Repositories\Interfaces\DiagnoseRepositoryInterface;

class DiagnoseRepository implements DiagnoseRepositoryInterface
{
    public function all()
    {
        return Diagnose::all();
    }

    public function create(array $data)
    {
        return Diagnose::create($data);
    }
}
