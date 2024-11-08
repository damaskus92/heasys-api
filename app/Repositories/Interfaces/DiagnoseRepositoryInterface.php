<?php

namespace App\Repositories\Interfaces;

interface DiagnoseRepositoryInterface
{
    public function all();

    public function create(array $data);
}
