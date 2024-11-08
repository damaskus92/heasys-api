<?php

namespace App\Repositories\Interfaces;

interface AppointmentRepositoryInterface
{
    public function all();

    public function find(int $id);

    public function create(array $data);

    public function update(array $data, int $id);
}
