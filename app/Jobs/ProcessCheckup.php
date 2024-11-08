<?php

namespace App\Jobs;

use App\Enums\StatusEnum;
use App\Models\Appointment;
use App\Models\CheckupProgress;
use App\Models\Service;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessCheckup implements ShouldQueue
{
    use Queueable;

    protected $appointment;

    /**
     * Create a new job instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $diagnose = $this->appointment->diagnose->name;

        $services = [];

        switch ($diagnose) {
            case 'Ringan':
                $services[] = Service::where('name', 'Obat')->first();
                break;

            case 'Berat':
                $services[] = Service::where('name', 'Obat')->first();
                $services[] = Service::where('name', 'Rawat Inap')->first();
                break;

            case 'Kritis':
                $services[] = Service::where('name', 'Obat')->first();
                $services[] = Service::where('name', 'Rawat Inap')->first();
                $services[] = Service::where('name', 'ICU')->first();
                break;
        }

        foreach ($services as $service) {
            if ($service) {
                CheckupProgress::create([
                    'appointment_id' => $this->appointment->id,
                    'service_id' => $service->id,
                    'status' => StatusEnum::PROCESS
                ]);
            }
        }
    }
}
