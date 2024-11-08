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
     *
     * @OA\Get(
     *     path="/api/appointments",
     *     summary="List all appointments",
     *     description="Fetch a list of all appointments",
     *     tags={"Appointment"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/AppointmentResource")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $appointments = $this->service->all();
        $appointments->load(['patient', 'diagnose', 'checkups.service']);

        return response()->json(AppointmentResource::collection($appointments), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/appointments",
     *     summary="Create new appointment",
     *     description="Create new appointment",
     *     tags={"Appointment"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreAppointmentRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful",
     *         @OA\JsonContent(ref="#/components/schemas/AppointmentResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Content",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="patient_id",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         example="The selected patient is invalid."
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="diagnose_id",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         example="The selected diagnose is invalid."
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
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
     *
     * @OA\Get(
     *     path="/api/appointments/{id}",
     *     summary="Show specific appointment",
     *     description="Show specific appointment",
     *     tags={"Appointment"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful",
     *         @OA\JsonContent(ref="#/components/schemas/AppointmentResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Appointment not found")
     *         )
     *     )
     * )
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
     *
     * @OA\Put(
     *     path="/api/appointments/{id}",
     *     summary="Update specific appointment",
     *     description="Update specific appointment",
     *     tags={"Appointment"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateAppointmentRequest")
     *     ),
     *     @OA\Response(
     *         response=202,
     *         description="Accepted",
     *         @OA\JsonContent(ref="#/components/schemas/AppointmentResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Appointment not found or update failed")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Content",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="patient_id",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         example="The selected patient is invalid."
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="diagnose_id",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         example="The selected diagnose is invalid."
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         example="The selected status is invalid."
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function update(int $id, UpdateAppointmentRequest $request)
    {
        $appointment = $this->service->update($request->validated(), $id);

        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found or update failed'], 404);
        }

        $appointment->load(['patient', 'diagnose', 'checkups.service']);

        return response()->json(new AppointmentResource($appointment), 202);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
