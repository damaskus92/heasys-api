<?php

namespace App\Repositories;

use App\Models\Service;
use App\Repositories\Interfaces\ServiceRepositoryInterface;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function all()
    {
        return Service::all();
    }

    public function create(array $data)
    {
        return Service::create($data);
    }
}
