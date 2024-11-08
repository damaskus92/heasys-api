<?php

namespace App\Repositories\Interfaces;

interface ServiceRepositoryInterface
{
    public function all();

    public function create(array $data);
}
