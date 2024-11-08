<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'Obat'],
            ['name' => 'Rawat Inap'],
            ['name' => 'ICU'],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
