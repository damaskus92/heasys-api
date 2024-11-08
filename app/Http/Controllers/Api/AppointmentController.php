<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\StoreAppointmentRequest;
use App\Http\Requests\Appointment\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Jobs\ProcessCheckup;
use App\Models\Appointment;
use App\Services\AppointmentService;

class AppointmentController extends Controller
{
    public function __construct(
        protected AppointmentService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = $this->service->all();
        $appointments->load(['patient', 'diagnose', 'checkups.service']);

        return response()->json(AppointmentResource::collection($appointments), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        $appointment = $this->service->create($request->validated());
        $appointment->load(['patient', 'diagnose']);

        ProcessCheckup::dispatch($appointment);

        return response()->json(new AppointmentResource($appointment), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $appointment = $this->service->find($id);

        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        $appointment->load(['patient', 'diagnose', 'checkups.service']);

        return response()->json(new AppointmentResource($appointment), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, UpdateAppointmentRequest $request)
    {
        $appointment = $this->service->update($request->validated(), $id);

        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found or update failed'], 404);
        }

        $appointment->load(['patient', 'diagnose', 'checkups.service']);

        return response()->json(new AppointmentResource($appointment), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
