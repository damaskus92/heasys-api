<?php

namespace App\Providers;

use App\Repositories\AppointmentRepository;
use App\Repositories\DiagnoseRepository;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Repositories\Interfaces\DiagnoseRepositoryInterface;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Repositories\PatientRepository;
use App\Repositories\ServiceRepository;
use App\Services\AppointmentService;
use App\Services\DiagnoseService;
use App\Services\PatientService;
use App\Services\TreatmentService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PatientRepositoryInterface::class, PatientRepository::class);
        $this->app->bind(DiagnoseRepositoryInterface::class, DiagnoseRepository::class);
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(AppointmentRepositoryInterface::class, AppointmentRepository::class);

        $this->app->bind(PatientService::class, function (Application $app) {
            return new PatientService($app->make(PatientRepositoryInterface::class));
        });
        $this->app->bind(DiagnoseService::class, function (Application $app) {
            return new DiagnoseService($app->make(DiagnoseRepositoryInterface::class));
        });
        $this->app->bind(TreatmentService::class, function (Application $app) {
            return new TreatmentService($app->make(ServiceRepositoryInterface::class));
        });
        $this->app->bind(AppointmentService::class, function (Application $app) {
            return new AppointmentService($app->make(AppointmentRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
